<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 06.05.15
 * Time: 00:50
 */

namespace BraintreePayments\Service;

use BraintreePayments\Model\CreditCard;
use BraintreePayments\Model\CustomerInterface;
use BraintreePayments\Model\Discount;
use BraintreePayments\src\BraintreePayments\Service\DiscountsService;

/**
 * Factory and proxy methods for Braintree communication
 * @package BraintreePayments\Service
 */
class CustomersService extends AbstractService
{
    /**
     * Check customer exists in Braintree vault
     *
     * @param CustomerInterface $customerInterface
     * @return bool
     */
    public function exists(CustomerInterface $customerInterface)
    {
        $this->initEnvironment();

        $customerExists = true;

        try {
            \Braintree_Customer::find($customerInterface->getCustomerId());
        } catch (\Braintree_Exception_NotFound $e) {
            $customerExists = false;
        }

        return $customerExists;
    }

    /**
     * Find customer in service
     *
     * @param $id
     * @return null|\Braintree_Customer
     */
    public function find($id)
    {
        $this->initEnvironment();

        try {
            return \Braintree_Customer::find($id);
        } catch (\Braintree_Exception_NotFound $e) {
            return null;
        }
    }

    /**
     * Init customer with data from
     *
     * @param CustomerInterface $customerInterface
     * @return bool
     */
    public function init(CustomerInterface $customerInterface)
    {
        if (!$customerInterface->getCustomerId()) {
            return false;
        }

        $btCustomer = $this->find($customerInterface->getCustomerId());

        if (!$btCustomer) {
            return false;
        }

        $customerInterface->hydrateApiCustomer($btCustomer);

        if (count($btCustomer->creditCards)) {

            $defaultCard = $btCustomer->creditCards[0];
            $customerInterface->setCreditCard([
                'last' => $defaultCard->last4,
                'img' => $defaultCard->imageUrl,
            ]);
        }

        return true;
    }

    /**
     * Save new user data in vault
     *
     * @param CustomerInterface $customerInterface
     * @param CreditCard $card
     */
    public function store(CustomerInterface $customerInterface, CreditCard $card = null)
    {
        $this->initEnvironment();

        $customerData = $customerInterface->extractForApi();
        $req = array_merge_recursive(['creditCard' => $card->extract()], $customerData);

        $result = \Braintree_Customer::create($req);

        $this->validateResponse($result);

        $customerInterface->setCustomerId($result->customer->id);
    }

    /**
     * Update existing customer data
     *
     * @param CustomerInterface $customerInterface
     * @param CreditCard $card
     */
    public function update(CustomerInterface $customerInterface, CreditCard $card = null)
    {
        $this->initEnvironment();

        // Prepare data
        $customerData = $customerInterface->extractForApi();
        $newDefaultAddress = $customerData['creditCard']['billingAddress'];
        unset($customerData['creditCard']); // unset credit card data - we updating users data only

        // Update users basic data
        $result = \Braintree_Customer::update($customerInterface->getCustomerId(), $customerData);
        $this->validateResponse($result);

        // Store some response data for further use
        $currentDefaultAddressId = $result->customer->addresses[0]->id;
        $currentDefaultCardToken = $result->customer->creditCards[0]->token;

        // Update users address
        $result = \Braintree_Address::update($customerInterface->getCustomerId(), $currentDefaultAddressId, $newDefaultAddress);
        $this->validateResponse($result);

        if ($card) {
            $result = \Braintree_PaymentMethod::update($currentDefaultCardToken, $card->extract());
            $this->validateResponse($result);
        }
    }

    /**
     * Remove customer from Vault
     *
     * @param CustomerInterface $customerInterface
     * @throws \Exception
     */
    public function remove(CustomerInterface $customerInterface)
    {
        $result = \Braintree_Customer::delete($customerInterface->getCustomerId());

        $this->validateResponse($result);

        $customerInterface->setCustomerId(null);
    }

    /**
     * Check if user has active subscription
     *
     * @param CustomerInterface $customerInterface
     * @return bool
     * @throws \Exception
     */
    public function hasValidSubscription(CustomerInterface $customerInterface)
    {
        if (!$customerInterface->getSubscriptionId()) {
            return false;
        }

        $this->initEnvironment();

        $result = \Braintree_Subscription::find($customerInterface->getSubscriptionId());

        $this->validateResponse($result);

        return $result->status == \Braintree_Subscription::ACTIVE;
    }
}
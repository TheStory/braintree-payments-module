<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 31.05.15
 * Time: 18:17
 */

namespace BraintreePayments\Entity;

use BraintreePayments\Model\CreditCard;
use BraintreePayments\Model\CustomerInterface;
use Common\Entity\AbstractUpdateableEntity;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * Abstract customer entity. Provide standard fields and functionality suited in most scenarios.
 * @package BraintreePayments\Entity
 *
 * @MappedSuperclass
 */
class AbstractStandardCustomer extends AbstractUpdateableEntity implements CustomerInterface
{
    /**
     * @var string
     * @Column(type="string", name="customer_id")
     */
    protected $customerId;
    /**
     * @var string
     * @Column(type="string", name="subscription_id")
     */
    protected $subscriptionId;
    /**
     * @var string
     * @Column(type="string")
     */
    protected $discounts;
    /**
     * @var string
     */
    protected $companyName;
    /**
     * @var string
     */
    protected $firstName;
    /**
     * @var string
     */
    protected $lastName;
    /**
     * @var string
     */
    protected $address;
    /**
     * @var string
     */
    protected $vatNumber;
    /**
     * @var string
     */
    protected $city;
    /**
     * @var string
     */
    protected $country;
    /**
     * @var string
     */
    protected $postalCode;

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return AbstractStandardCustomer
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return AbstractStandardCustomer
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return AbstractStandardCustomer
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     * @return AbstractStandardCustomer
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
        return $this;
    }

    /**
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param string $customerId
     * @return AbstractStandardCustomer
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @param $id
     * @return AbstractStandardCustomer
     */
    public function setSubscriptionId($id)
    {
        $this->subscriptionId = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiscountId()
    {
        return $this->discountId;
    }

    /**
     * @param string $discountId
     * @return AbstractStandardCustomer
     */
    public function setDiscountId($discountId)
    {
        $this->discountId = $discountId;
        return $this;
    }

    /**
     * Fill object with data from Braintree
     *
     * @param \Braintree_Customer $customer
     */
    public function hydrateApiCustomer(\Braintree_Customer $customer)
    {
        $this->setCustomerId($customer->id)
            ->setCompanyName($customer->company)
            ->setFirstName($customer->firstName)
            ->setLastName($customer->lastName)
            ->setVatNumber(isset($customer->customFields['vat_number']) ? $customer->customFields['vat_number'] : null);

        /** @var \Braintree_Address $defaultAddress */
        if (count($customer->addresses)) {
            $defaultAddress = $customer->addresses[0];
            $this->setCountry($defaultAddress->countryCodeAlpha2)
                ->setCity($defaultAddress->locality)
                ->setPostalCode($defaultAddress->postalCode)
                ->setAddress($defaultAddress->streetAddress);
        }
    }

    /**
     * Fill object with standard form data
     *
     * @param $data
     */
    public function hydrateFormData($data)
    {
        $customerData = $data['customer'];

        $this->setAddress($customerData['address'])
            ->setCompanyName($customerData['companyName'])
            ->setPostalCode($customerData['postalCode'])
            ->setCity($customerData['city'])
            ->setCountry($customerData['country'])
            ->setFirstName($customerData['firstName'])
            ->setLastName($customerData['lastName'])
            ->setVatNumber($customerData['vatNumber']);
    }

    /**
     * Get array data used for store user in Braintree vault
     *
     * @return array
     */
    public function extractForApi()
    {
        $address = [
            'countryCodeAlpha2' => $this->getCountry(),
            'locality'          => $this->getCity(),
            'postalCode'        => $this->getPostalCode(),
            'streetAddress'     => $this->getAddress(),
        ];

        $response = [
            'company'      => $this->getCompanyName(),
            'firstName'    => $this->getFirstName(),
            'lastName'     => $this->getLastName(),
            'customFields' => [
                'vat_number' => $this->getVatNumber(),
            ],
            'creditCard' => [
                'billingAddress' => $address,
            ],
        ];

        return $response;
    }

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     * @return AbstractStandardCustomer
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return AbstractStandardCustomer
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return AbstractStandardCustomer
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     * @return AbstractStandardCustomer
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;
        return $this;
    }

    /**
     * @return array
     */
    public function getDiscounts()
    {
        return json_decode($this->discounts) ?: [];
    }

    /**
     * Array of discount structures:
     * array['product'] - discounted product ID
     * array['discount'] - BrainTree discount ID
     *
     * @param array $discounts
     * @return AbstractStandardCustomer
     */
    public function setDiscounts(array $discounts)
    {
        $this->discounts = json_encode($discounts);
        return $this;
    }
}
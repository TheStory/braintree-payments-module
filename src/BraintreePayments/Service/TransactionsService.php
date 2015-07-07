<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 05.05.15
 * Time: 23:24
 */

namespace BraintreePayments\Service;

use BraintreePayments\Model\Sale;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

/**
 * Transaction operations. Providing product sales mechanisms.
 * @package BraintreePayments\Service
 */
class TransactionsService extends AbstractService implements EventManagerAwareInterface
{
    private $eventManager;

    /**
     * Inject an EventManager instance
     *
     * @param  EventManagerInterface $eventManager
     * @return void
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers([__CLASS__, get_called_class()]);
        $this->eventManager = $eventManager;
    }

    /**
     * Retrieve the event manager
     *
     * Lazy-loads an EventManager instance if none registered.
     *
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager());
        }

        return $this->eventManager;
    }

    /**
     * Process single sale. If customer provided in Sale object - customer will charged. If
     * customer not exists in Braintree vault - customer entry will created. After successful sale
     * event bp:sold will raised.
     *
     * @param Sale $sale
     * @return \Braintree_Transaction
     * @throws \Exception
     */
    public function sale(Sale $sale)
    {
        $this->initEnvironment();
        $config = $this->getServiceLocator()->get('config')['bt_payments'];
        $isRegistration = false;

        // set default currency if not provided in sale object
        if (!$sale->getCurrency()) {
            $sale->setCurrency($config['default_currency']);
        }

        // calculate price
        $amount = $sale->getAmount();
        $tax = $sale->getTax();
        $taxAmount = 0;
        if ($tax) {
            $taxAmount = $sale->getAmount() * $sale->getTax() / 100;
            $amount += $taxAmount;
        }

        // prepare sales data
        $salesData = [
            'amount' => (string)sprintf('%01.2F', $amount),
            'taxAmount' => (string)sprintf('%01.2F', $taxAmount),
            'merchantAccountId' => $config['merchant_accounts'][$sale->getCurrency()],
        ];

        /** @var CustomersService $customerService */
        $customerService = $this->getServiceLocator()->get(BT_CUSTOMERS_SERVICE);
        if ($customer = $sale->getCustomer()) { // sale with customer
            if ($customer->getCustomerId()) { // existing customer
                if (!$customerService->exists($customer)) { // check id in vault
                    throw new \Exception('Provided customer not exists in vault');
                }
            } else { // new customer - store in vault
                if (!$sale->getCreditCard()) { // must have credit card
                    throw new \Exception('Credit card not provided');
                }
                $customerService->store($customer, $sale->getCreditCard());
                $isRegistration = true;
            }

            $salesData['customerId'] = $customer->getCustomerId();
        } else { // simple single sale
            if (!$sale->getCreditCard()) {
                throw new \Exception('Credit card not provided');
            }

            $salesData['creditCard'] = $sale->getCreditCard()->extract();
        }

        $response = \Braintree_Transaction::sale($salesData);

        try {
            $this->validateResponse($response);
        } catch (\Exception $e) {
            if ($isRegistration) { // remove just registered user, because no payment
                $customerService->remove($sale->getCustomer());
            }
            throw $e;
        }

        // post successful sale event
        $this->getEventManager()->trigger('bp::sold', $this, $response->transaction);

        return $response->transaction;
    }
}
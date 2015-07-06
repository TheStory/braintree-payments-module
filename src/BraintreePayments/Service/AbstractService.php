<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 06.05.15
 * Time: 00:50
 */

namespace BraintreePayments\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractService implements ServiceLocatorAwareInterface
{
    private $serviceLocator;
    /**
     * @var bool is Braintree environment initialized
     */
    private $isInitialized = false;

    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function __invoke()
    {
        return $this;
    }

    /**
     * Initial config of Braintree, should becalled before Braintree API communication operations
     */
    protected function initEnvironment()
    {
        if ($this->isInitialized === false) {
            $config = $this->getServiceLocator()->get('config')['bt_payments'];

            \Braintree_Configuration::environment($config['environment']);
            \Braintree_Configuration::merchantId($config['merchant_id']);
            \Braintree_Configuration::publicKey($config['public_key']);
            \Braintree_Configuration::privateKey($config['private_key']);

            $this->isInitialized = true;
        }
    }

    /**
     * Validate response from Braintree methods
     *
     * @param $response
     * @return \Braintree_Transaction
     * @throws \Exception
     */
    protected function validateResponse($response)
    {
        if ($response instanceof \Braintree_Result_Error) { // validate transaction response
            $errorMessages = [];

            /** @var \Braintree_Transaction $transaction */
            if ($transaction = $response->transaction) {
                $errorMessages[] = sprintf('We cannot process your payment. %s (%s).', $transaction->processorResponseText, $transaction->processorResponseCode);
            } else {
                /** @var \Braintree_Error_Validation $error */
                foreach ($response->errors->deepAll() as $error) {
                    $errorMessages[] = $error->message;
                }
            }
            throw new \Exception(implode(' ', $errorMessages));
        }
    }
}
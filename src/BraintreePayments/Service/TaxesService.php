<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 07.07.15
 * Time: 20:54
 */

namespace BraintreePayments\Service;

use Zend\Cache\Storage\Adapter\Apc;
use Zend\Http\Client;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * EU taxes operations
 * @package BraintreePayments\Service
 */
class TaxesService implements ServiceLocatorAwareInterface
{
    const DEFAULT_TAX = 0;
    /**
     * @var ServiceLocatorInterface
     */
    private $serviceLocator;

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

    /**
     * Get VAT tax for provided country
     *
     * @param string $countryCode ISO country code eg. PL, if null will return tax for current taxation country
     * @param bool $isCompany
     * @return int base tax rate or 0 if country not found
     * @throws \Exception if HTTP response status code not 200
     */
    public function countryTax($countryCode = null, $isCompany = false)
    {

        // prepare country code param
        $config = $this->serviceLocator->get('config');
        $taxationCountry = $config['bt_payments']['taxation_country'];
        $countryCode = $countryCode ?: $taxationCountry;


        if ($countryCode !== $taxationCountry && $isCompany) { // reverse charge
            return self::DEFAULT_TAX;
        }

        // calculate tax for individual

        /** @var Apc $cache */
        $cache = $this->getServiceLocator()->get('cache.longlife');

        // check if data is in cache
        if ($cache->hasItem('taxes')) {
            $data = $cache->getItem('taxes');
        } else {
            // API request for all countries data
            $client = new Client();
            $client->setUri('https://raw.githubusercontent.com/modmore/euvatrates.com/master/rates.json')
                ->setOptions([
                    'ssltransport' => 'tls',
                    'sslverifypeer' => false,
                ])
                ->send();

            // process API response
            $response = $client->getResponse();
            if ($response->getStatusCode() != 200) { // Wrong response
                throw new \Exception('Response error. Status code: ' . $response->getStatusCode());
            }

            $responseData = json_decode($response->getBody());
            $data = $responseData->rates;

            // store in cache
            $cache->setItem('taxes', $data);
        }

        // search for provided country code
        foreach ($data as $k => $v) {
            if ($k == strtoupper($countryCode)) { // found! return tax
                return $v->standard_rate;
            }
        }

        return self::DEFAULT_TAX; // not found tax data
    }
}
<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 03.07.15
 * Time: 07:52
 */

namespace BraintreePayments\Service;

// @todo Add caching
use Zend\Cache\Storage\Adapter\AbstractAdapter;

/**
 * Discount operations service
 * @package BraintreePayments\src\BraintreePayments\Service
 */
class DiscountsService extends AbstractService
{
    /**
     * Return array of discounts
     *
     * @return \Braintree_Discount[]
     * @throws \Exception
     */
    public function all()
    {
        /** @var AbstractAdapter $cache */
        $cache = $this->getServiceLocator()->get('cache.longlife');

        if ($cache->hasItem('discount_list')) {
            $all = $cache->getItem('discount_list');
        } else {
            $this->initEnvironment();
            /** @var \Braintree_Discount[] $all */
            $all = \Braintree_Discount::all();
            $this->validateResponse($all);

            $cache->setItem('discount_list', $all);
        }

        return $all;
    }

    /**
     * Find discount data by Braintree ID
     *
     * @param $id - Braintree discount ID
     * @return \Braintree_Discount|null
     */
    public function find($id)
    {
        foreach ($this->all() as $single) {
            if ($single->id == $id) {
                return $single;
            }
        }

        return null;
    }
}
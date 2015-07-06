<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 03.07.15
 * Time: 07:52
 */

namespace BraintreePayments\Service;

// @todo Add caching

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
        $this->initEnvironment();

        /** @var \Braintree_Discount[] $all */
        $all = \Braintree_Discount::all();

        $this->validateResponse($all);

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
        $all = $this->all();

        foreach ($all as $single) {
            if ($single->id == $id) {
                return $single;
            }
        }

        return null;
    }
}
<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 03.07.15
 * Time: 15:43
 */

namespace BraintreePayments\Service;

// @todo Add caching

/**
 * Class PlansService
 * @package BraintreePayments\Service
 */
class PlansService extends AbstractService
{
    private $plans;

    /**
     * @return \Braintree_Plan[]
     * @throws \Exception
     */
    public function all()
    {
        $this->initEnvironment();

        $plans = \Braintree_Plan::all();

        $this->validateResponse($plans);

        return $plans;
    }

    /**
     * @param $id
     * @return \Braintree_Plan|null
     */
    public function find($id)
    {
        if (!$this->plans) {
            $this->plans = $this->all();
        }

        foreach ($this->plans as $plan) {
            if ($plan->id == $id) {
                return $plan;
            }
        }

        return null;
    }
}
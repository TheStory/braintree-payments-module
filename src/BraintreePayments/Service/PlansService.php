<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 03.07.15
 * Time: 15:43
 */

namespace BraintreePayments\Service;

// @todo Add caching
use Zend\Cache\Storage\Adapter\AbstractAdapter;

/**
 * Class PlansService
 * @package BraintreePayments\Service
 */
class PlansService extends AbstractService
{
    /**
     * @return \Braintree_Plan[]
     * @throws \Exception
     */
    public function all()
    {
        /** @var AbstractAdapter $cache */
        $cache = $this->getServiceLocator()->get('cache.longlife');

        if ($cache->hasItem('plan_list')) {
            $all = $cache->getItem('plan_list');
        } else {
            $this->initEnvironment();
            /** @var \Braintree_Plan[] $all */
            $all = \Braintree_Plan::all();
            $this->validateResponse($all);

            $cache->setItem('plan_list', $all);
        }

        return $all;
    }

    /**
     * @param $id
     * @return \Braintree_Plan|null
     */
    public function find($id)
    {
        foreach ($this->all() as $plan) {
            if ($plan->id == $id) {
                return $plan;
            }
        }

        return null;
    }
}
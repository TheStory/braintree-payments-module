<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 08.07.15
 * Time: 10:28
 */

namespace BraintreePayments\Service;

class SubscriptionsService extends AbstractService
{
    /**
     * Find subscription by id
     *
     * @param string $id
     * @return \Braintree_Subscription
     * @throws \Exception
     */
    public function find($id)
    {
        $this->initEnvironment();

        $result = \Braintree_Subscription::find($id);
        $this->validateResponse($result);

        return $result;
    }

    /**
     * Create new subscription for user
     *
     * @param $paymentToken
     * @param $planId
     * @return \Braintree_Result_Error|\Braintree_Subscription
     * @throws \Exception
     */
    public function createForToken($paymentToken, $planId)
    {
        $this->initEnvironment();

        $result = \Braintree_Subscription::create([
            'paymentMethodToken' => $paymentToken,
            'planId' => $planId,
        ]);

        $this->validateResponse($result);

        return $result->subscription;
    }
}
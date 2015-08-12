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
     * @param $price
     * @param $currency
     * @return \Braintree_Result_Error|\Braintree_Subscription
     * @throws \Exception
     */
    public function createForToken($paymentToken, $planId, $price, $currency)
    {
        $this->initEnvironment();

        // get merchant account for provided currency

        $merchantAccounts = $this->getModuleConfiguration()['merchant_accounts'];

        $currentMerchantAccountId = null;
        foreach ($merchantAccounts as $key => $value) {
            if ($key == $currency) {
                $currentMerchantAccountId = $value;
                break;
            }
        }

        if (!$currentMerchantAccountId) {
            throw new \Exception('Wrong currency provided');
        }

        $result = \Braintree_Subscription::create([
            'paymentMethodToken' => $paymentToken,
            'planId' => $planId,
            'price' => $price,
            'merchantAccountId' => $currentMerchantAccountId
        ]);

        $this->validateResponse($result);

        return $result->subscription;
    }
}
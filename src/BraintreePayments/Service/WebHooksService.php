<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 10.07.2015
 * Time: 11:22
 */

namespace BraintreePayments\Service;


/**
 * Class WebHooksService
 * @package BraintreePayments\Service
 */
class WebHooksService extends AbstractService
{
    /**
     * @param $code
     * @return string
     * @throws \Braintree_Exception_InvalidChallenge
     */
    public function verifyChallenge($code)
    {
        $this->initEnvironment();
        return \Braintree_WebhookNotification::verify($code);
    }
}
<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 10.07.2015
 * Time: 09:52
 */

namespace BraintreePayments\Controller;

use Common\Controller\AbstractController;

class WebHooksController extends AbstractController
{
    public function renewSubscriptionAction()
    {
        if ($this->params()->fromQuery('bt_challenge')) {
            echo \Braintree_WebhookNotification::verify($this->params()->fromQuery('bt_challenge'));
        }

        return $this->getResponse();
    }
}
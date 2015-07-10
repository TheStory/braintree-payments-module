<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 10.07.2015
 * Time: 09:52
 */

namespace BraintreePayments\Controller;

use BraintreePayments\Service\WebHooksService;
use Common\Controller\AbstractController;

class WebHooksController extends AbstractController
{
    public function renewSubscriptionAction()
    {
        if ($challenge = $this->params()->fromQuery('bt_challenge')) {
            /** @var WebHooksService $service */
            $service = $this->getServiceLocator()->get(BT_WEBHOOKS_SERVICE);
            $service->verifyChallenge($challenge);
        }

        return $this->getResponse();
    }
}
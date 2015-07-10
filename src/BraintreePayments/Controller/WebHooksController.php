<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 10.07.2015
 * Time: 09:52
 */

namespace BraintreePayments\Controller;

use Application\Entity\Product\Subscription;
use Application\Service\Repository\ProductsRepository;
use BraintreePayments\Service\SubscriptionsService;
use BraintreePayments\Service\WebHooksService;
use Common\Controller\AbstractController;
use Users\Service\Repository\UsersRepository;

class WebHooksController extends AbstractController
{
    public function renewSubscriptionAction()
    {
        /** @var WebHooksService $service */
        $service = $this->getServiceLocator()->get(BT_WEBHOOKS_SERVICE);

        // is challenge?
        if ($challenge = $this->params()->fromQuery('bt_challenge')) {
            echo $service->verifyChallenge($challenge);
            return $this->getResponse();
        }

        // is post?
        if (!$this->getRequest()->isPost()) {
            $this->getResponse()->setStatusCode(400);
            throw new \Exception('Bad request');
        }

        $post = $this->params()->fromPost();

        // is data in correct format
        if (!isset($post['bt_signature']) || !isset($post['bt_payload'])) {
            $this->getResponse()->setStatusCode(422);
            throw new \Exception('Wrong format');
        }

        // process notification
        $notification = $service->parse($post['bt_signature'], $post['bt_payload']);
        if ($notification->kind == \Braintree_WebhookNotification::SUBSCRIPTION_CHARGED_SUCCESSFULLY) {
            $subscriptionId = $notification->subscription->id;

            /** @var SubscriptionsService $subscriptions */
            $subscriptions = $this->getServiceLocator()->get(BT_SUBSCRIPTIONS_SERVICE);
            $subscription = $subscriptions->find($subscriptionId);

            /** @var ProductsRepository $products */
            $products = $this->getServiceLocator()->get('repo.products');
            $product = $products->findProductByBtPlanId($subscription->planId);
            if (!$product) {
                throw new \Exception('Product not found');
            }

            if ($product instanceof Subscription) {
                /** @var UsersRepository $users */
                $users = $this->getServiceLocator()->get('repo.users');
                $user = $users->findOneBySubscriptionId($subscriptionId);
                if (!$user) {
                    throw new \Exception('User not found');
                }

                // update users amount of posts
                $user->setPostsLeft($product->getPostsAmount());
                $this->getDoctrine()->flush($user);
            }
        }

        return $this->getResponse();
    }
}
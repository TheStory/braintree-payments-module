<?php
namespace BraintreePayments;

define('BT_CUSTOMERS_SERVICE', 'svc.payment_customers');
define('BT_PLANS_SERVICE', 'svc.payment_plans');
define('BT_TRANSACTIONS_SERVICE', 'svc.payment_transactions');
define('BT_TAXES_SERVICE', 'svc.payment_taxes');
define('BT_SUBSCRIPTIONS_SERVICE', 'svc.payment_subscriptions');
define('BT_WEBHOOKS_SERVICE', 'svc.payment_webhooks');

return [
    'bt_payments' => [
        'taxation_country' => 'PL',
        'environment' => 'sandbox',
        'merchant_accounts' => [

        ],
        'merchant_id' => '',
        'public_key' => '',
        'private_key' => '',
        'customer_class' => '',
    ],
    'router' => [
        'routes' => [
            'bt' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/bt/:action',
                    'defaults' => [
                        '__NAMESPACE__' => __NAMESPACE__ . '\Controller',
                        'controller' => 'WebHooks',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'invokables' => [
            __NAMESPACE__ . '\Controller\WebHooks' => __NAMESPACE__ . '\Controller\WebHooksController',
        ],
    ],
    'service_manager' => [
        'invokables' => [
            BT_CUSTOMERS_SERVICE => 'BraintreePayments\Service\CustomersService',
            BT_PLANS_SERVICE => 'BraintreePayments\Service\PlansService',
            BT_TRANSACTIONS_SERVICE => 'BraintreePayments\Service\TransactionsService',
            BT_TAXES_SERVICE => 'BraintreePayments\Service\TaxesService',
            BT_SUBSCRIPTIONS_SERVICE => 'BraintreePayments\Service\SubscriptionsService',
            BT_WEBHOOKS_SERVICE => 'BraintreePayments\Service\WebHooksService',
        ],
    ],
];

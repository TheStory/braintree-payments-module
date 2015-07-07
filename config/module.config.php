<?php
namespace BraintreePayments;

define('BT_CUSTOMERS_SERVICE', 'svc.payment_customers');
define('BT_PLANS_SERVICE', 'svc.payment_plans');
define('BT_DISCOUNTS_SERVICE', 'svc.payment_discounts');
define('BT_TRANSACTIONS_SERVICE', 'svc.payment_transactions');

return [
    'bt_payments'     => [],
    'service_manager' => [
        'invokables' => [
            BT_CUSTOMERS_SERVICE => 'BraintreePayments\Service\CustomersService',
            BT_PLANS_SERVICE => 'BraintreePayments\Service\PlansService',
            BT_TRANSACTIONS_SERVICE => 'BraintreePayments\Service\TransactionsService',
            BT_DISCOUNTS_SERVICE => 'BraintreePayments\Service\DiscountsService',
        ],
    ],
];

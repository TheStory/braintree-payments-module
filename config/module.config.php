<?php
namespace BraintreePayments;

define('BT_CUSTOMERS_SERVICE', 'svc.payment_customers');
define('BT_PLANS_SERVICE', 'svc.payment_plans');
define('BT_DISCOUNTS_SERVICE', 'svc.payment_discounts');
define('BT_TRANSACTIONS_SERVICE', 'svc.payment_transactions');
define('BT_TAXES_SERVICE', 'svc.payment_taxes');

return [
    'bt_payments' => [
        'taxation_country' => 'PL',
    ],
    'service_manager' => [
        'invokables' => [
            BT_CUSTOMERS_SERVICE => 'BraintreePayments\Service\CustomersService',
            BT_PLANS_SERVICE => 'BraintreePayments\Service\PlansService',
            BT_TRANSACTIONS_SERVICE => 'BraintreePayments\Service\TransactionsService',
            BT_DISCOUNTS_SERVICE => 'BraintreePayments\Service\DiscountsService',
            BT_TAXES_SERVICE => 'BraintreePayments\Service\TaxesService',
        ],
    ],
];

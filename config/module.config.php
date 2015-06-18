<?php
namespace BraintreePayments;

return [
    'bt_payments'     => [],
    'service_manager' => [
        'invokables' => [
            'svc.payment_customers'    => 'BraintreePayments\Service\CustomersService',
            'svc.payment_transactions' => 'BraintreePayments\Service\TransactionsService',
        ],
    ],
];

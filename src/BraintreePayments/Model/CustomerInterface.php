<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 06.05.15
 * Time: 00:47
 */

namespace BraintreePayments\Model;

interface CustomerInterface
{
    public function getCustomerId();

    public function setCustomerId($id);

    public function hydrateApiCustomer(\Braintree_Customer $customer);

    public function extractForApi();
}
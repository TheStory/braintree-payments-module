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
    /**
     * @return string|null
     */
    public function getCustomerId();

    /**
     * @param string $id
     * @return CustomerInterface
     */
    public function setCustomerId($id);

    /**
     * @return string|null
     */
    public function getSubscriptionId();

    /**
     * @param string $id
     * @return CustomerInterface
     */
    public function setSubscriptionId($id);

    /**
     * @return string|null
     */
    public function getCreditCard();

    /**
     * @param string $id
     * @return CustomerInterface
     */
    public function setCreditCard($id);

    public function hydrateApiCustomer(\Braintree_Customer $customer);

    public function extractForApi();
}
<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 05.05.15
 * Time: 23:57
 */

namespace BraintreePayments\Model;

class Sale
{
    /**
     * @var string
     */
    protected $amount;

    /**
     * @var CreditCard
     */
    protected $creditCard;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     * @return Sale
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return CreditCard
     */
    public function getCreditCard()
    {
        return $this->creditCard;
    }

    /**
     * @param CreditCard $creditCard
     * @return Sale
     */
    public function setCreditCard(CreditCard $creditCard)
    {
        $this->creditCard = $creditCard;
        return $this;
    }

    /**
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param CustomerInterface $customer
     * @return Sale
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
        return $this;
    }
}
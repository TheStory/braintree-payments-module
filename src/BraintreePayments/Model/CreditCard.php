<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 06.05.15
 * Time: 00:06
 */

namespace BraintreePayments\Model;

class CreditCard
{
    /**
     * @var string
     */
    protected $cardholderName;

    /**
     * @var int
     */
    protected $cvv;

    /**
     * @var int
     */
    protected $expirationMonth;

    /**
     * @var int
     */
    protected $expirationYear;

    /**
     * @var string
     */
    protected $number;

    /**
     * Extract values from an object
     *
     * @return array
     */
    public function extract()
    {
        return [
            'cardholderName'  => $this->getCardholderName(),
            'number'          => $this->getNumber(),
            'expirationMonth' => $this->getExpirationMonth(),
            'expirationYear'  => $this->getExpirationYear(),
            'cvv'             => $this->getCvv(),
        ];
    }

    /**
     * @return string
     */
    public function getCardholderName()
    {
        return $this->cardholderName;
    }

    /**
     * @param string $cardholderName
     * @return CreditCard
     */
    public function setCardholderName($cardholderName)
    {
        $this->cardholderName = $cardholderName;
        return $this;
    }

    /**
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param string $number
     * @return CreditCard
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationMonth()
    {
        return $this->expirationMonth;
    }

    /**
     * @param int $expirationMonth
     * @return CreditCard
     */
    public function setExpirationMonth($expirationMonth)
    {
        $this->expirationMonth = $expirationMonth;
        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationYear()
    {
        return $this->expirationYear;
    }

    /**
     * @param int $expirationYear
     * @return CreditCard
     */
    public function setExpirationYear($expirationYear)
    {
        $this->expirationYear = $expirationYear;
        return $this;
    }

    /**
     * @return int
     */
    public function getCvv()
    {
        return $this->cvv;
    }

    /**
     * @param int $cvv
     * @return CreditCard
     */
    public function setCvv($cvv)
    {
        $this->cvv = $cvv;
        return $this;
    }

    /**
     * Populate object data standard from form data
     *
     * @param $data
     */
    public function hydrateFormData($data)
    {
        $this->setCardholderName($data['ccCardholderName'])
            ->setNumber($data['ccNumber'])
            ->setExpirationMonth($data['ccMonth'])
            ->setExpirationYear($data['ccYear'])
            ->setCvv($data['ccCvc']);
    }
}
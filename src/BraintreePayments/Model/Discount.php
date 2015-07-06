<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 03.07.15
 * Time: 08:12
 */

namespace BraintreePayments\Model;

/**
 * Class Discount
 * @package BraintreePayments\Model
 */
class Discount
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var float
     */
    private $value;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Discount
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param float $value
     * @return Discount
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}
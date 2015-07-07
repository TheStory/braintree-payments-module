<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 20.04.15
 * Time: 08:34
 */

namespace BraintreePayments\Validator;

use BraintreePayments\Model\CountryCollection;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;
use Zend\Validator\Regex;

/**
 * EU VAT validator
 * @package BraintreePayments\Validator
 */
class VatValidator extends AbstractValidator
{
    const WRONG_FORMAT = 'wrong_format';

    protected $messageTemplates = [
        self::WRONG_FORMAT => 'Wrong VAT number format',
    ];

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param mixed $value
     * @param mixed $context
     *
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value, $context = null)
    {
        if (!isset($context['companyName']) || empty($context['companyName'])) {
            return true;
        }

        if (isset($context['country']) && !empty($context['country'])) {
            $countryCollection = new CountryCollection();
            if (array_key_exists($context['country'], $countryCollection->getEuCountries())) {
                $regexValidator = new Regex('/^((AT)?U[0-9]{8}|(BE)?0[0-9]{9}|(BG)?[0-9]{9,10}|(CY)?[0-9]{8}L|(CZ)?[0-9]{8,10}|(DE)?[0-9]{9}|(DK)?[0-9]{8}|(EE)?[0-9]{9}|(EL|GR)?[0-9]{9}|(ES)?[0-9A-Z][0-9]{7}[0-9A-Z]|(FI)?[0-9]{8}|(FR)?[0-9A-Z]{2}[0-9]{9}|(GB)?([0-9]{9}([0-9]{3})?|[A-Z]{2}[0-9]{3})|(HU)?[0-9]{8}|(IE)?[0-9]S[0-9]{5}L|(IT)?[0-9]{11}|(LT)?([0-9]{9}|[0-9]{12})|(LU)?[0-9]{8}|(LV)?[0-9]{11}|(MT)?[0-9]{8}|(NL)?[0-9]{9}B[0-9]{2}|(PL)?[0-9]{10}|(PT)?[0-9]{9}|(RO)?[0-9]{2,10}|(SE)?[0-9]{12}|(SI)?[0-9]{8}|(SK)?[0-9]{10})$/');

                if (!$regexValidator->isValid($value)) {
                    $this->error(self::WRONG_FORMAT);
                    return false;
                }
            }
        }

        return true;
    }
}
<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 05.05.15
 * Time: 17:54
 */

namespace BraintreePayments\Form;

use BraintreePayments\InputFilter\PaymentFieldsetFilter;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CreditCardFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('creditCard');

        $this->setLabel(_('Credit Card'));

        $this->add(
            [
                'name'       => 'ccCardholderName',
                'type'       => 'text',
                'attributes' => [
                    'size'         => 250,
                    'autocomplete' => 'off',
                ],
                'options'    => [
                    'label' => _('Cardholder name'),
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'ccNumber',
                'type'       => 'text',
                'attributes' => [
                    'size'         => 20,
                    'autocomplete' => 'off',
                ],
                'options'    => [
                    'label' => _('Credit card number'),
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'ccCvc',
                'type'       => 'text',
                'attributes' => [
                    'size'         => 4,
                    'autocomplete' => 'off',
                ],
                'options'    => [
                    'label' => _('CVV'),
                ],
            ]
        );

        $monthsRange = range(1, 12);
        $this->add(
            [
                'name'    => 'ccMonth',
                'type'    => 'select',
                'options' => [
                    'label'         => _('Month'),
                    'value_options' => array_combine($monthsRange, $monthsRange),
                    'empty_option'  => _('-- Month --'),
                    'value'         => date('m'),
                ],
            ]
        );

        $yearsRange = range(date('Y'), date('Y') + 5);
        $this->add(
            [
                'name'    => 'ccYear',
                'type'    => 'select',
                'options' => [
                    'label'         => _('Year'),
                    'value_options' => array_combine($yearsRange, $yearsRange),
                    'empty_option'  => _('-- Year --'),
                ],
            ]
        );
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        $inputFilter = new PaymentFieldsetFilter();
        return $inputFilter->getInputs();
    }
}
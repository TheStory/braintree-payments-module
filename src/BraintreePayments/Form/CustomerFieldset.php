<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 31.05.15
 * Time: 16:21
 */

namespace BraintreePayments\Form;

use BraintreePayments\InputFilter\CustomerFieldsetFilter;
use BraintreePayments\Model\CountryCollection;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;

class CustomerFieldset extends Fieldset implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('customer');

        $this->setLabel('Customer data');

        $this->add(
            [
                'name'    => 'firstName',
                'type'    => 'text',
                'options' => [
                    'label' => 'First Name',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'lastName',
                'type'    => 'text',
                'options' => [
                    'label' => 'Last Name',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'companyName',
                'type'    => 'text',
                'options' => [
                    'label' => 'Company name',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'address',
                'type'    => 'text',
                'options' => [
                    'label' => 'Address',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'vatNumber',
                'type'    => 'text',
                'options' => [
                    'label' => 'VAT Number',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'city',
                'type'    => 'text',
                'options' => [
                    'label' => 'City',
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'country',
                'type'    => 'select',
                'options' => [
                    'label'         => 'Country',
                    'value_options' => CountryCollection::getAllCountries(),
                    'empty_option'  => '-- Select from list --'
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'postalCode',
                'type'    => 'text',
                'options' => [
                    'label' => 'Postal code',
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
        $filter = new CustomerFieldsetFilter();
        return $filter->getInputs();
    }
}
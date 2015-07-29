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
    protected $currentInputFilters;

    public function __construct()
    {
        parent::__construct('customer');

        $this->setLabel(_('Customer data'));

        $this->add(
            [
                'name'    => 'firstName',
                'type'    => 'text',
                'options' => [
                    'label' => _('First Name'),
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'lastName',
                'type'    => 'text',
                'options' => [
                    'label' => _('Last Name'),
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'companyName',
                'type'    => 'text',
                'options' => [
                    'label' => _('Company name'),
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'address',
                'type'    => 'text',
                'options' => [
                    'label' => _('Address'),
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'vatNumber',
                'type'    => 'text',
                'options' => [
                    'label' => _('VAT Number'),
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'city',
                'type'    => 'text',
                'options' => [
                    'label' => _('City'),
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'country',
                'type'    => 'select',
                'options' => [
                    'label'         => _('Country'),
                    'value_options' => CountryCollection::getAllCountries(),
                    'empty_option'  => _('-- Select from list --')
                ],
            ]
        );

        $this->add(
            [
                'name'    => 'postalCode',
                'type'    => 'text',
                'options' => [
                    'label' => _('Postal code'),
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
        if (!$this->currentInputFilters) {
            $filter = new CustomerFieldsetFilter();
            $this->currentInputFilters = $filter->getInputs();
        }

        return $this->currentInputFilters;
    }

    /**
     * @return array
     */
    public function getCurrentInputFilters()
    {
        return $this->currentInputFilters;
    }

    /**
     * @param array $currentInputFilters
     * @return CustomerFieldset
     */
    public function setCurrentInputFilters(array $currentInputFilters)
    {
        $this->currentInputFilters = $currentInputFilters;
        return $this;
    }
}
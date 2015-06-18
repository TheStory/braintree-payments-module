<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 31.05.15
 * Time: 16:54
 */

namespace BraintreePayments\InputFilter;

use Zend\InputFilter\InputFilter;

class CustomerFieldsetFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            [
                'name'       => 'companyName',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
                'validators' => [
                    [
                        'name'    => 'string_length',
                        'options' => [
                            'max' => 250,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'firstName',
                'required' => false,
                'filters'  => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
            ]
        );

        $this->add(
            [
                'name'     => 'lastName',
                'required' => false,
                'filters'  => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'address',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
                'validators' => [
                    [
                        'name'    => 'string_length',
                        'options' => [
                            'max' => 250,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'              => 'vatNumber',
                'required'          => true,
                'allow_empty'       => true,
                'continue_if_empty' => true,
                'filters'           => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
                'validators'        => [
                    ['name' => 'BraintreePayments\Validator\VatValidator'],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'city',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
                'validators' => [
                    [
                        'name'    => 'string_length',
                        'options' => [
                            'min' => 2,
                            'max' => 100,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'postalCode',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
                'validators' => [
                    [
                        'name'    => 'string_length',
                        'options' => [
                            'min' => 2,
                            'max' => 20,
                        ],
                    ],
                ],
            ]
        );
    }
}
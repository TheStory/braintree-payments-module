<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 05.05.15
 * Time: 20:14
 */

namespace BraintreePayments\InputFilter;

use Zend\InputFilter\InputFilter;

class PaymentFieldsetFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(
            [
                'name'       => 'ccCardholderName',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                ],
                'validators' => [
                    [
                        'name'    => 'string_length',
                        'options' => [
                            'min' => 3,
                            'max' => 175,
                        ],
                    ],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'ccNumber',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                    [
                        'name'    => 'callback',
                        'options' => [
                            'callback' => function ($value) {
                                return str_replace(' ', '', $value);
                            }
                        ],
                    ],
                ],
                'validators' => [
                    ['name' => 'credit_card'],
                ],
            ]
        );

        $this->add(
            [
                'name'       => 'ccCvc',
                'required'   => true,
                'filters'    => [
                    ['name' => 'string_trim'],
                    ['name' => 'strip_tags'],
                    [
                        'name'    => 'callback',
                        'options' => [
                            'callback' => function ($value) {
                                return str_replace(' ', '', $value);
                            }
                        ],
                    ],
                ],
                'validators' => [
                    [
                        'name'    => 'string_length',
                        'options' => [
                            'min' => 3,
                            'max' => 4,
                        ],
                    ],
                ],
            ]
        );
    }
}
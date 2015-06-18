<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 31.05.15
 * Time: 16:36
 */

namespace BraintreePayments\Model;

/**
 * Country collection with helper filtering methods
 * @package BraintreePayments\Model
 */
class CountryCollection
{
    protected static $countries = [
        'eu'    => [
            'AT' => 'Austria',
            'BE' => 'Belgium',
            'BG' => 'Bulgaria',
            'CY' => 'Cyprus',
            'CZ' => 'Czech Republic',
            'DK' => 'Denmark',
            'EE' => 'Estonia',
            'FI' => 'Finland',
            'FR' => 'France',
            'DE' => 'Germany',
            'GR' => 'Greece',
            'HU' => 'Hungary',
            'IE' => 'Ireland',
            'IT' => 'Italy',
            'LV' => 'Latvia',
            'LT' => 'Lithuania',
            'LU' => 'Luxembourg',
            'MT' => 'Malta',
            'NL' => 'Netherlands',
            'PL' => 'Poland',
            'PT' => 'Portugal',
            'RO' => 'Romania',
            'SK' => 'Slovakia',
            'SI' => 'Slovenia',
            'ES' => 'Spain',
            'SE' => 'Sweden',
            'GB' => 'United Kingdom',
        ],
        'other' => [
            'AL' => 'Albania',
            'BA' => 'Bosnia And Herzegovina',
            'CN' => 'China',
            'FO' => 'Faroe Islands',
            'GE' => 'Georgia',
            'JP' => 'Japan',
            'IS' => 'Iceland',
            'IL' => 'Israel',
            'LI' => 'Liechtenstein',
            'MK' => 'Macedonia',
            'MD' => 'Moldova',
            'ME' => 'Montenegro',
            'NO' => 'Norway',
            'RS' => 'Serbia',
            'CH' => 'Switzerland',
            'TR' => 'Turkey',
            'UA' => 'Ukraine',
            'US' => 'United States',
        ],
    ];

    public static function getAllCountries()
    {
        $countries = self::getEuCountries() + self::getNonEuCountries();
        asort($countries);
        return $countries;
    }

    public static function getEuCountries()
    {
        return self::$countries['eu'];
    }

    public static function getNonEuCountries()
    {
        return self::$countries['other'];
    }
}
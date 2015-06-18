<?php
/**
 * Copyright: STORY DESIGN Sp. z o.o.
 * Author: Yaroslav Shatkevich
 * Date: 05.05.15
 * Time: 17:59
 */

namespace BraintreePayments\View\Helper;

use Zend\View\Helper\AbstractHelper;

class ClientToken extends AbstractHelper
{
    function __invoke()
    {
        return \Braintree_ClientToken::generate();
    }
}
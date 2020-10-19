<?php

use Payum\Core\PayumBuilder;
use Payum\Core\Payum;

/** @var Payum $payum */
$payum = (new PayumBuilder())
        ->addDefaultStorages()

        ->addGateway('Paypal', [
            'factory' => 'paypal_express_checkout',
            'username' => '',
            'password' => '',
            'signature' => '',
            'sandbox' => true,
        ])

        ->getPayum()
        ;
App::resolving('payum.builder', function(\Payum\Core\PayumBuilder $payumBuilder) {
    $payumBuilder
        ->addGateway('offline', ['factory' => 'offline'])
    ;
});
<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Paypal extends Controller
{
    public $sandbox;
    public $endpointURL;
    public $clientID;
    public $secret;
    public $currencycode;
    function _construct()
    {
        $this->sandbox = config('paypal.sandbox'); // PAYPAL_SANDBOX = true/false
        $this->endpointURL = $this->sandbox ? 'https://api.sandbox.paypal.com' : 'https://api.paypal.com'; //Set endpoint URL for PayPal API Calls 
        $this->clientID = config('paypal.clientid'); // PAYPAL_CLIENTID
        $this->secret = config('paypal.clientsecret'); //PAYPAL_CLIENTSECRET
        $this->currencycode = "EUR";
    }
    /**
     * Capture Order for PayPal and get all response data
     */
    public function Capture($amount)
    {
        $data['intent'] = "CAPTURE";
        $data['purchase_units']['amount']['currency_code'] = $this->currencycode;
        $data['purchase_units']['amount']['value'] = $amount;
        $data = json_encode($data);
        $response = Http::withBasicAuth($this->clientID, $this->secret)
                        ->withBody($data, 'application/json')
                        ->post($this->endpointURL);
        if ($response['status'] == "CREATED")
            return redirect($response['links'][1]['href']);
    }
}

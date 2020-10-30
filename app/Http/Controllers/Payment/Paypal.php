<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Paypal extends Controller
{
    protected $sandbox;
    protected $endpointURL;
    protected $clientID;
    protected $secret;
    protected $currencycode;
    function _construct()
    {
        $this->sandbox = true; // PAYPAL_SANDBOX = true/false
        $this->endpointURL = $this->sandbox ? 'https://api.sandbox.paypal.com' : 'https://api.paypal.com'; //Set endpoint URL for PayPal API Calls 
        $this->clientID = 'AYC4xTxGRw3ZJr2Do41D9FI-i2nEkoew2vwggla9Y9FhCKYc7X7aesqEtLoFMoUkcjUpLptYeBqA6iRC'; // PAYPAL_CLIENTID
        $this->secret = 'EKj3WZ-qvQkjmGsyFCOdaQE4LiU4Af837EkUvBvLhUsweKnGN0fKhp4Nno_LoFCTDx7sRA-cAd6tJw8O'; //PAYPAL_CLIENTSECRET
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
                        ->post($this->endpointURL.'/v2/checkout/orders');
        if ($response['status'] == "CREATED")
            return redirect($response['links'][1]['href']);
            
    }
}

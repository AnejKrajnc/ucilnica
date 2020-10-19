<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Paypal extends Controller
{
    public $paypalEnv = 'sandbox';
    public $paypalURL = 'https://api.sandbox.paypal.com/v1/'; //Production: https://api.paypal.com/v1/
    public $paypalClientID = '';
    private $paypalSecret = '';

    public function validate($paymentID, $paymentToken, $payerID, $productID) {
        $response = Http::withBasicAuth($this->paypalClientID, $this->paypalSecret)->post($this->paypalURL.'oauth2/token', ['grant_type' => 'client_credentials']);
        if (empty($response)) {
            return false;
        }
        else {
            $jsonData = json_decode($response);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $jsonData->access_token,
                'Accept' => 'application/json',
                'Content-Type' => 'application/xml'
            ])->get($this->paypalURL.'/payments/payment/'.$paymentID);

            return json_decode($response);
        }
    }
}

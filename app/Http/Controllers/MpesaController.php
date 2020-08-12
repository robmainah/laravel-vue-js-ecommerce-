<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Safaricom\Mpesa\Mpesa;
use Safaricom\Mpesa\TransactionCallbacks;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MpesaController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    public function lipaNaMpesaPassword()
    {
        $lipa_time = Carbon::rawParse('now')->format('YmdHms');
        $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
        $BusinessShortCode = 174379;
        $timestamp =$lipa_time;
        $lipa_na_mpesa_password = base64_encode($BusinessShortCode.$passkey.$timestamp);
        return $lipa_na_mpesa_password;
    }

        /**
     * Lipa na M-PESA STK Push method
     * */
    public function customerMpesaSTKPush()
    {
        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$this->generateAccessToken()));
        $curl_post_data = [
            //Fill in the request parameters with valid values
            'BusinessShortCode' => 174379,
            'Password' => $this->lipaNaMpesaPassword(),
            'Timestamp' => Carbon::rawParse('now')->format('YmdHms'),
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => 5,
            'PartyA' => 254703249349, // replace this with your phone number
            'PartyB' => 174379,
            'PhoneNumber' => 254703249349, // replace this with your phone number
            'CallBackURL' => 'https://rokam.co.ke/',
            'AccountReference' => "Mpesa tutorial",
            'TransactionDesc' => "Testing stk push on sandbox"
        ];

        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        $curl_response = curl_exec($curl);
        return $curl_response;

    }

    public function generateAccessToken()
    {
        $consumer_key="GvKYsYcww7GBbD4FXwCulefamij08pPb";
        $consumer_secret="7B8kIAz6YQbkxTGC";
        $credentials = base64_encode($consumer_key.":".$consumer_secret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$credentials));
        curl_setopt($curl, CURLOPT_HEADER,false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        $access_token=json_decode($curl_response);
        return $access_token->access_token;
    }

    public function create()
    {
        $mpesa = new Mpesa();

        // require "./Http/Callback.php";

        $BusinessShortCode = '174379';
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = '1';
        $PartyA = '254703249349';
        $PartyB = '174379';
        $PhoneNumber = '254703249349';
        $CallBackURL = 'http://codeinnovits.com/app/mpesa/callbackurl.php';
        $AccountReference = 'Avion';
        $TransactionDesc = 'Mpesa Testing payment';
        $Remarks = 'Mpesa Testing payment';

        $stkPushSimulation = $mpesa->STKPushSimulation(
            $BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks
        );

        echo $stkPushSimulation . "<br><br>";

        //$callback = new TransactionCallbacks();

        //$callbackResponse = $callback->processSTKPushRequestCallback();

        //return $callbackResponse;
    }

    public function callback()
    {
        $callback = new TransactionCallbacks();

        $callbackResponse = $callback->processSTKPushRequestCallback();

        $mpesa = new \Safaricom\Mpesa\Mpesa();

        echo $callbackData = $mpesa->getDataFromCallback();

        echo "call--<br>";

        echo $callbackResponse;
    }
}

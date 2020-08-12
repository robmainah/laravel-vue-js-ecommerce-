<?php

namespace App\Mpesa;

use Safaricom\Mpesa\Mpesa;


class CreatePayment
{
    public function create ()
    {
        $mpesa = new Mpesa();

        $BusinessShortCode = '174379';
        $LipaNaMpesaPasskey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';
        $TransactionType = 'CustomerPayBillOnline';
        $Amount = '1';
        $PartyA = '254703249349';
        $PartyB = '174379';
        $PhoneNumber = '254703249349';
        $CallBackURL = 'http://03ebd4f7.ngrok.io/callback';
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
        echo $stkPushSimulation;
        // return "success";
        //return TransactionCallbacks::processSTKPushRequestCallback();
    }
}

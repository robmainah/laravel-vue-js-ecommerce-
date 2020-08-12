<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

require '../vendor/autoload.php';
use AfricasTalking\SDK\AfricasTalking;

class PaymentApi extends Model
{
    public function payment() {
        // Set your app credentials
        $username   = "sandbox";
        $apikey     = "adf29c0386bfb37e1691c465ad5e1282aa5dd0ef25a9f79f7bf7f4e1a395fc82";

        // Initialize the SDK
        $AT         = new AfricasTalking($username, $apikey);

        // Get the payments service
        $payments   = $AT->payments();

        // Set the name of your Africa's Talking payment product
        $productName  = "sandbox";

        // Set the phone number you want to send to in international format
        $phoneNumber  = "+254703249349";

        // Set The 3-Letter ISO currency code and the checkout amount
        $currencyCode = "KES";
        $amount       = 100.00;

        // Set any metadata that you would like to send along with this request.
        // This metadata will be included when we send back the final payment notification
        $metadata = [
            "agentId"   => "654",
            "productId" => "321"
        ];

        // Thats it, hit send and we'll take care of the rest.
        try {
            $result = $payments->mobileCheckout([
                "productName"  => $productName,
                "phoneNumber"  => $phoneNumber,
                "currencyCode" => $currencyCode,
                "amount"       => $amount,
                "metadata"     => $metadata
            ]);

            print_r($result);
        } catch(Exception $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}

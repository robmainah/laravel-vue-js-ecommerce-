<?php

namespace App\Paypal;

use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\Plan;
use PayPal\Api\ShippingAddress;

class SubscriptionAgreement extends Paypal
{
    public function create ($id)
    {

        $agreement = new Agreement();

        $agreement->setName('Base Agreement')
                    ->setDescription('Basic Agreement')
                    ->setStartDate('2019-08-17T9:45:04Z');

        $agreement->setPlan($this->plan($id));

        $agreement->setPayer($this->payer());

        $agreement->setShippingAddress($this->shippingAddress());

        $agreement = $agreement->create($this->apiContext);

        // Step 2.1 : Between Step 2 and Step 3
//        $apiContext->setConfig(
//            array(
//                'log.LogEnabled' => true,
//                'log.FileName' => 'PayPal.log',
//                'log.LogLevel' => 'DEBUG'
//            )
//        );

        return redirect($agreement->getApprovalLink());

    }

    public function execute ($token)
    {
        $agreement = new Agreement();

        try {

            $agreement->execute($token, $this->apiContext);

        } catch (Exception $ex) {
//            exit(1);
        }
    }

    /**
     * @param $id
     * @return Plan
     */
    protected function plan($id): Plan
    {
        $plan = new Plan();
        $plan->setId($id);
        return $plan;
    }

    /**
     * @return Payer
     */
    protected function payer(): Payer
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        return $payer;
    }

    /**
     * @return ShippingAddress
     */
    protected function shippingAddress(): ShippingAddress
    {
        $shippingAddress = new ShippingAddress();
        $shippingAddress->setLine1('111 First Street')
            ->setCity('Saratoga')
            ->setState('CA')
            ->setPostalCode('95070')
            ->setCountryCode('US');
        return $shippingAddress;
    }
}

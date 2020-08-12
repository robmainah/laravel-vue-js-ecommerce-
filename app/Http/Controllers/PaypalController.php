<?php

namespace App\Http\Controllers;

use App\Paypal\CreatePayment;
use App\Paypal\ExecutePayment;

class PaypalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPayment()
    {
        $payment = new CreatePayment();

        return $payment->create();
        // return $payment->create(request()->all());
    }

    public function executePayment()
    {
        $payment = new ExecutePayment();

        return $payment->execute();
    }
}
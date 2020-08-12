<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentApi;

class AfricasTalkingController extends Controller
{
    public function index () {
        $payment = new PaymentApi ();
        $payment -> payment();
    }
}

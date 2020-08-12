<?php

namespace App\Http\Controllers;

use App\Paypal\SubscriptionAgreement;
use App\Paypal\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function createPlan()
    {
        $plan = new SubscriptionPlan();

        $plan->create();

        return $plan;
    }

    public function listPlan()
    {
        $plan = new SubscriptionPlan();

        return $plan->listPlan();
    }

    public function showPlan($id)
    {
        $plan = new SubscriptionPlan();

        return $plan->getPlanDetails($id);
    }

    public function activatePlan($id)
    {
        $plan = new SubscriptionPlan();

        return $plan->activate($id);
    }

    public function CreateAgreement($id)
    {
        $agreement = new SubscriptionAgreement;

        return $agreement->create($id);
    }

    public function executeAgreement($status)
    {

        if ($status == "true") {
            $agreement = new SubscriptionAgreement;

            $agreement->execute(request('token'));

            return "done";
        }
    }
}
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use App\Customer;

// use Symfony\Component\HttpFoundation\Request;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('index');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('index');
    }

    public function checkUserExist(SymfonyRequest $request)
    {
        return Customer::where('email', $request->email)->first();
    }

    // protected function sendResetLinkResponse(Request $request, $response)
    // {
    //     return response()->json(['emailSent' => "Email sent succefully", 'data' => $response]);
    //     // return response()->json(['emailSent' => "Email sent succefully"]);
    // }

    // protected function sendResetLinkFailedResponse(Request $request, $response)
    // {

    //     return response()->json(['emailFailed' => "Failed to send email."]);
    //     // return response()->json(['emailFailed' => "Failed to send email."]);
    // }
}
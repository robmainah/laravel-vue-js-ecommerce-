<?php

namespace App\Http\Controllers\Auth;

// use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Customer;
use App\Mail\CustomerVerifyEmail;
use Mail;
use Str;
// use App\Mail\CustomerVerifyEmail;
// use Mail;
// use App\Notifications\RegisterCustomerNotification as RegisterCustomerNotice;
// use App\Mail\verifyEmail;

// use App\Notifications\VerifyEmailNotification;
// use Illuminate\Notifications\Notifiable;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    // use Notifiable;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:customers'],
            'idNumber' => ['required', 'numeric'],
            "phone_number" => 'required|numeric',
            "address" => ["required"],
            "gender" => ["required"],
            'password_confirmation' => ['required'],
            'password' => ['required', 'string',  'confirmed', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Customer
     */
    protected function create(array $data)
    {
        // return Customer::generateCustomerNumber();
        $customer = Customer::create([
            'name' => ucwords($data['name']),
            'email' => $data['email'],
            'idNumber' => $data['idNumber'],
            'customerId' => Customer::generateCustomerNumber(),
            'phone_number' => $data['phone_number'],
            'address' => $data['address'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),
            // 'email_verified_at' => Null,
            'email_verified_at' => Str::random(60),
        ]);

        // $thisUser = Customer::findOrFail($customer->id);
        // $this->sendEmailVerifyNotice($thisUser);

        return $customer;
        // return redirect(route('customer.login'));
    }

    public function verifyEmail()
    {
        return view('index');
    }

    public function sendEmailVerifyNotice($thisUser)
    {
        Mail::to($thisUser['email'])->send(new CustomerVerifyEmail($thisUser));
        // $thisUser->notify(new RegisterCustomerNotice($thisUser));
    }

    public function emailVerified($email, $email_verified_at)
    {
        $customer = Customer::where(['email' => $email])->first();
        // $customer = Customer::where(['email' => $email, 'email_verified_at' => $email_verified_at])->first();
        if ($customer) {
            Customer::where(['email' => $email, 'email_verified_at' => $email_verified_at])->update(['active' => '1', 'email_verified_at' => now()]);

            // return response()->json(['email_verified' => true]);
            return redirect(route('customer.login'));
        }
    }
}
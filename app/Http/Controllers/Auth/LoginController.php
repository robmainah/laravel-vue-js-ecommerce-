<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Customer;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except(['logout']);
    }

    /*
        protected function afterAuthenticate()
        {
            $user = Auth::guard()->user();
            $userInfo = [
                'name' => $user->name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
            ];

            return response()->json(['loginSuccess' => true, 'user' => $userInfo]);
        }
    */

    public function showLoginForm()
    {
        // return view('auth.login');
        return view('index');
    }

    // protected function credentials(Request $request)
    // {
    //     return $request->only($this->username(), 'password');
    //     // return ['email' => $request->{$this->username()}, 'password' => $request->password, 'active' => '1'];
    // }
}
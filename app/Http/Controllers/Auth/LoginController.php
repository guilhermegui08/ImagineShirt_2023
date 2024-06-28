<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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
    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        if (!auth()->attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
            ]);
        }

        // Additional check for blocked attribute
        $user = $this->guard()->user();
        if ($user->blocked) {
            auth()->logout();
            throw ValidationException::withMessages([
                'email' => [trans('auth.blocked')],
            ]);
        }

        return true;
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->user_type == 'E') {
            return redirect()->route('orders.index');
        }else {
            return redirect()->route('home');
        }
    }

        /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}

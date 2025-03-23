<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

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

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request): RedirectResponse
    {   
        $input = $request->all();    
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ],[
            'email.required' => 'email tidak boleh kosong',
            "email.exists" => "Akun tidak ditemukan",
            'password.required' => 'password tidak boleh kosong' 
        ]);
     
        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->is_superadmin == 1) {
                return redirect()->route('dashboard');
            }else if (auth()->user()->is_superadmin	== 0) {
                return redirect()->route('customer.home');
            }else{
                return redirect()->route('login');
            }
        }else{
            return redirect()->route('login')
            ->withErrors([
                'password' => 'password tidak sesuai',
            ]);
        }
          
    }
}

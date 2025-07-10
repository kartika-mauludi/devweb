<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\SubscribeRecord;
use Illuminate\Support\Facades\Mail;
use App\Mail\reminder;
use auth;


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
            $user = auth()->user();

            $currentSessionId = Session::getId();
        
            $lastSessionId = $user->last_session_id;
        
            if ($user->is_superadmin == 0 && $lastSessionId && $lastSessionId !== $currentSessionId) {
                DB::table('sessions')->where('id', $lastSessionId)->delete();
            }
            
            $user->last_session_id = $currentSessionId;
            $user->save();            

            if ($user->is_superadmin == 1) {
                return redirect()->route('admin.home');
            }else if ($user->is_superadmin	== 0) {
                $subscribe = SubscribeRecord::where('user_id',auth::user()->id)->first();
                if($subscribe){
                    if(\Carbon\Carbon::parse($subscribe->end_date) < now() && !empty($subscribe->end_date)){
                        $subscribe->account_status = "non-aktif";
                        $subscribe->save();
                    }
                    else if(now()->diffInDays(\Carbon\Carbon::parse($subscribe->end_date)) <=5 && !empty($subscribe->end_date) && $subscribe->subscribe_package_id != 99){
                        $data["user"] = $user;
                        $data["url"] = route('commision-config.store');;
                        Mail::to($user->email)->send(new reminder($data));
                    }
                }
                
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

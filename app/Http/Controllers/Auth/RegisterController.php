<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SubscribeRecord;
use App\Models\Payment; 
use App\Models\UserAffiliate;
use App\Models\AffiliateComission;
use App\Models\SubscribePackage;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Session;
use DB;
use auth;
use Exception;


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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'customer/home';

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ],
        [
            'email.unique' => 'Email Sudah Terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sama dengan password konfirmasi'
        ]
    );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
       
        try {
            DB::beginTransaction();
            $kode = Str::random(10);   
            $user =  User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'nomor' => $data['nomor'],
                    'refferal_code' => $kode,
                    'password' => Hash::make($data['password']),
                ]);

                // $input = $data->except('_token');
                $ref = request()->query('ref');
                if($ref){
                    $useraffiliate = User::where('refferal_code',$ref)->first();
                    $komisi = AffiliateComission::latest()->first();
                    UserAffiliate::Create(['user_id' => $useraffiliate->id,'usernew_id' => $user->id , 'status'=>'pending','amount'=>$komisi->amount]);
                };

                 $sub = SubscribeRecord::create([
                    'user_id' => $user->id,
                    'subscribe_package_id' => Session::get('id')
                ]);
        
                $latest = Payment::latest()->first();
                if (! $latest) {
                    $string= '0000001';
                }else{
            
                $string = preg_replace("/[^0-9\.]/", '', $latest->id_invoice);
                }
              
                Payment::create([
                    'user_id' => $user->id,
                    'subscribe_record_id' => $sub->id,
                    'id_invoice' => 'ivc-'. sprintf('%06d', $string+1),
                    'price' => Session::get('price'),
                    'discount' => Session::get('discount'),
                    'status' => 'pending'
                ]);
        //   });
          DB::commit();
          return $user;
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return back()->with('error', 'ada kesalahan');
        }
        return redirect()->route('customer.home');
       
        
    }

    

    public function price(){
        $packages =  SubscribePackage::all();
        return view('price',compact('packages'));
     }
}

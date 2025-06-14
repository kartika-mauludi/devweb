<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubscribeRecord;
use App\Models\Payment; 
use App\Models\UserAffiliate;
use App\Models\AffiliateComission;
use App\Models\AffiliateDetails;
use App\Models\SubscribePackage;
use App\Models\UniversityAccount;
use App\Models\University;
use App\Models\ConfigAdmin;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\info;
use App\Mail\notif;
use App\Mail\new_register;
use Session;
use DB;
use Auth;
use Illuminate\Support\Arr;



class RegisterController extends Controller
{
    public function __construct()
    {
        $this->admin_email = User::with('config')->find(optional(ConfigAdmin::first())?->email)?->email;

    }
    public function register(Request $request){
    
        $data = $request->input();
        $validator =  Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
        ],
        [
            'email.unique' => 'Email Sudah Terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Password tidak sama dengan password konfirmasi'
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
       }
        DB::beginTransaction(); 
        try {
                $ref = Session::get('ref');
                if($ref){
                    $useraffiliate = User::where('referral_code',$ref)->first();
                    $cek_status_komisi = AffiliateComission::all();
                    $id_komisi =  AffiliateDetails::where('user_id',$useraffiliate->id)->first();
                    $subscribe = SubscribePackage::where('id',Session::get('id'))->first();
                    if($cek_status_komisi->isNotEmpty()){
                        if(!is_null($id_komisi)){
                            $komisi = AffiliateComission::where('id',$id_komisi->affiliate_comission_id)->first();
                        }else{
                            $komisi = AffiliateComission::where('status','=','global')->first();
                        }
                        $komisi = AffiliateComission::latest()->first();
                        if($komisi->type == "percentage"){
                            $persentase = $komisi->amount;
                            $komisi_amount = $persentase/100 * $subscribe->price;
                        }
                        else if($komisi->type == "fixed"){
                            $komisi_amount = $komisi->amount;
                        }
                    }else{
                        $komisi_amount = 10000; 
                    }

                    $kode = Str::random(10);  
                     $user =  User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'nomor' => $data['nomor'],
                        'referral_code' => $kode,
                        'password' => Hash::make($data['password']),
                        'akun_id' => ''
                    ]);
                    UserAffiliate::Create(['user_id' => $useraffiliate->id,'usernew_id' => $user->id , 'status'=>'pending','amount'=>round($komisi_amount, 1)]);
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
              
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'subscribe_record_id' => $sub->id,
                    'id_invoice' => 'inv-'. sprintf('%06d', $string+1),
                    'price' => Session::get('price'),
                    // 'discount' => Session::get('discount'),
                    'status' => 'pending',
                    'order_id' => rand()
                ]);
                 DB::commit();
                 Auth::loginUsingId($user->id);
                 
                 $data["user"] = $user;
                 $data["invoice"] = $payment->id_invoice;

                 Mail::to($this->admin_email ?? "afibrulyansah@unusa.ac.id")->send(new new_register($data));
                return redirect()->route('customer/langganan.qris',$payment->user_id);

                // $response = Http::post(route('subscribepayment'), $datas);
                // return $response;

             } catch(\Exception $exp){
                DB::rollBack();
                report($exp);
                $message = $this::$message['error_register'];
                return back()->with('message',$message)->withInput();
         }
       
       
    }


    public function price(){
        Auth::logout();
        $packages =  SubscribePackage::all();
        return view('price',compact('packages'));
     }


}

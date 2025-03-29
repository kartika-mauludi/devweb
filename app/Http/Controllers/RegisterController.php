<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use Illuminate\Support\Facades\Http;
use Session;
use DB;
use Auth;


class RegisterController extends Controller
{
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
            return back ()->withErrors($validator);
        }

        DB::beginTransaction(); 
        try {
            $kode = Str::random(10);   
            $user =  User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'nomor' => $data['nomor'],
                    'referral_code' => $kode,
                    'password' => Hash::make($data['password']),
                ]);

                // $input = $data->except('_token');
                $ref = Session::get('ref');
                if($ref){
                    $useraffiliate = User::where('referral_code',$ref)->first();
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
              
                $payment = Payment::create([
                    'user_id' => $user->id,
                    'subscribe_record_id' => $sub->id,
                    'id_invoice' => 'inv-'. sprintf('%06d', $string+1),
                    'price' => Session::get('price'),
                    'discount' => Session::get('discount'),
                    'status' => 'pending'
                ]);
                 DB::commit();
                 Auth::loginUsingId($user->id);
                //  return redirect()->route('customer.home');
                $datas['user'] = $user->id;
                $datas['payment'] = $payment->id; 
                $datas['sub'] = $sub->id;

                // return  redirect()->route('subscribepayment', $datas);

                $response = Http::post(route('subscribepayment'), $datas);

                return $response;

             } catch(\Exception $exp){
            DB::rollBack();
            return response([
                'message' => $exp->getMessage(),
                'status' => 'failed'
            ], 400);
         }
       
       
    }

    public function price(){
        Auth::logout();
        $packages =  SubscribePackage::all();
        return view('price',compact('packages'));
     }


}

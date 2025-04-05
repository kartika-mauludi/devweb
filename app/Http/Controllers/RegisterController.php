<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SubscribeRecord;
use App\Models\Payment; 
use App\Models\UserAffiliate;
use App\Models\AffiliateComission;
use App\Models\SubscribePackage;
use App\Models\UniversityAccount;
use App\Models\University;
use Illuminate\Auth\Events\Failed;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\info;
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

            $univs = University::all();
            foreach ($univs as $univ){
                $akun[] = $this->cek_id($univ->id);
                $univ_id[] = $univ->id;
            }
    
            if($a = array_keys($akun, null, true)){
                // return $a;
                for($i = 0; $i < count($a); $i++){
                    $univid = $univ_id[$a[$i]];
                    $universiti[] = University::where('id',$univid)->pluck('name');
                }

                $data = $universiti;
                Mail::to('ludi@gmail.com')->send(new info($data));
            }
            else{
                $kode = Str::random(10);  
                $user =  User::create([
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'nomor' => $data['nomor'],
                        'referral_code' => $kode,
                        'password' => Hash::make($data['password']),
                        'akun_id' => $akun
                    ]);
            }
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

                $datas['user'] = $user->id;
                $datas['payment'] = $payment->id; 
                $datas['sub'] = $sub->id;
                $response = Http::post(route('subscribepayment'), $datas);

                return $response;

             } catch(\Exception $exp){
                DB::rollBack();
                report($exp);
                $message = $this::$message['error'];
                return $message;

         }
       
       
    }

    private function cek_id($id_univ){

        $user_akun = User::all()->where('akun_id','!=','')->pluck('akun_id');
        $account = UniversityAccount::where('university_id',$id_univ)->pluck('id');

        foreach ($user_akun as $id){
          foreach ($id as $i) {
            $akun_user[] = $i;
          }
        }

       $next_id = array_values(array_unique($akun_user));
       $jumlah_akun = count($account);
       $count = array_count_values($akun_user);

        foreach($count as $item => $jumlah){
            $id_akun[] = ['item' => $item, 'jumlah' => $jumlah];
        }

        for($i = 0; $i <= $jumlah_akun; $i++){
            if($id_akun[$i]['jumlah'] > 1){
                for($x = 0; $x <= $jumlah_akun; $x++){
                    $filtered = array_filter($count, function ($value) {
                        return $value < 2;
                    });
                }
                foreach($filtered as $id_ak => $jml){
                    $id_ak = ['id' => $id_ak, 'jumlah' => $jml];
                }
                if(empty($id_ak)){
                  $id_akun_univ = UniversityAccount::whereNotIn('id',$next_id)->where('university_id',$id_univ)->pluck('id')->first();
                } 
                return $id_akun_univ;
            }
            else{
            return "masih ada sisa";
            }
        }
    }

    public function price(){
        Auth::logout();
        $packages =  SubscribePackage::all();
        return view('price',compact('packages'));
     }


}

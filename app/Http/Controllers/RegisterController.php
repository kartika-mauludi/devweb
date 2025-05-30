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
use App\Mail\notif;
use App\Mail\new_register;
use Session;
use DB;
use Auth;
use Illuminate\Support\Arr;



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
            return back()->withErrors($validator)->withInput();
       }

       $univs = University::all();
           
            if($univs->isEmpty()){
                $data ="Data Universitas masih belum di isi";
                Mail::to('ludi.arjan1@gmail.com')->send(new notif($data));
            }

            foreach ($univs as $univ){
                $akun[] = $this->cek_id($univ->id);
                $univ_id[] = $univ->id;
            }

            if($a = array_keys($akun, null, true)){
                for($i = 0; $i < count($a); $i++){
                    $univid = $univ_id[$a[$i]];
                    $universiti[] = University::where('id',$univid)->pluck('name');
                }

                $data = $universiti;
                Mail::to('ludi.arjan1@gmail.com')->send(new info($data));

                $message = $this::$message['error_akun_univ'];
                return back()->with('message',$message)->withInput();
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
                        'akun_id' => $akun
                    ]);
            
                $ref = Session::get('ref');
                if($ref){
                    $useraffiliate = User::where('referral_code',$ref)->first();
                    $cek_komisi = AffiliateComission::all();
                    $subscribe = SubscribePackage::where('id',Session::get('id'))->first();
                   
                    if($cek_komisi->isNotEmpty()){
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
                    'discount' => Session::get('discount'),
                    'status' => 'pending',
                    'order_id' => rand()
                ]);
                 DB::commit();
                 Auth::loginUsingId($user->id);
                 Mail::to('ludi.arjan1@gmail.com')->send(new new_register($user));
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

    private function cek_id($id_univ){

        $user_akun = User::all()->where('akun_id','!=','')->pluck('akun_id');
        $account = UniversityAccount::where('university_id',$id_univ)->pluck('id');
        $jumlah_akun = count($account);
        if(collect($user_akun)->flatten()->filter()->isEmpty()){
            $list_akun_univ = UniversityAccount::where('university_id',$id_univ)->pluck('id')->first();
            return $id_akun_univ = $list_akun_univ ;
    
        }else{  

              for($i = 0; $i <= $jumlah_akun; $i++){
                $universitas = University::where('id',$id_univ)->first();
              }
                $batas = $universitas->batasan;
                $akun_user_raw = User::where('akun_id', '!=', '')
                            ->pluck('akun_id')
                            ->toArray();

                $flattened = Arr::flatten($akun_user_raw);
                $account_id = array_values(array_unique($flattened));
                $count = array_count_values($flattened);
                $filtered = array_filter($count, function ($val, $id) use ($batas, $account) {
                    return $val < $batas && in_array($id, $account->toArray());
                }, ARRAY_FILTER_USE_BOTH);

                if (!empty($filtered)) {
                $next_available_id = array_key_first($filtered);
                return $next_available_id;
                } else {
                $account_used = array_unique($flattened); 
                $id_akun_univ = UniversityAccount::where('university_id', $id_univ)
                    ->whereNotIn('id', $account_used)
                    ->pluck('id')
                    ->first();

                return $id_akun_univ ?? null;
                }
         
        }
        
    }

    public function price(){
        Auth::logout();
        $packages =  SubscribePackage::all();
        return view('price',compact('packages'));
     }


}

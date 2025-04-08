<?php

namespace App\Http\Controllers;

use App\Models\University;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\invoice;
use App\Mail\pending;
use App\Mail\expired;
use App\Mail\info;
use App\Models\UniversityAccount;
use App\Models\SubscribeRecord;
use Illuminate\Support\Arr;

class EmailController extends Controller
{
    public function invoice(){

        // $payment = Payment::latest('id')->where("user_id", 2)->first();
        // $subscribe = SubscribeRecord::with("subscribePackage")->where("user_id", $payment->user_id)->first();
        // $user = User::find(2);

        // try {
          
        //     $data = [
        //         'name' => $user->name,
        //         'email'=> $user->email,
        //         'invoice_id' => $payment->id_invoice,
        //         'paket' => $subscribe->subscribePackage->name,
        //         'start_date' => $subscribe->start_date,
        //         'end_date' => $subscribe->end_date,
        //         'price' => $subscribe->subscribePackage->price,
        //         'status' => $payment->status
        //     ];
        //     Mail::to($user->email)->send(new invoice($data));
    
        // } catch (\Throwable $th) {
        //     return "gagal";
        // }

        // return "sukses";

        $univs = University::all();
        foreach ($univs as $univ){
            $akun[] = $this->cek_id($univ->id);
            $univ_id[] = $univ->id;
        }

        // return $univ_id;

        if($a = array_keys($akun, null, true)){
            // return $a;
            for($i = 0; $i < count($a); $i++){
                $univid = $univ_id[$a[$i]];
                $universiti[] = University::where('id',$univid)->pluck('name');
            }

            $data = $universiti;
            return $data;
            // Mail::to('ludi@gmail.com')->send(new info($data));
        }
        else{
            return $akun;
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

                // Ambil semua akun_id dari user
                $akun_user_raw = User::where('akun_id', '!=', '')
                            ->pluck('akun_id')
                            ->toArray();

                // return $akun_user_raw;

                // Flatten array akun_id
                $flattened = Arr::flatten($akun_user_raw);

                $account_id = array_values(array_unique($flattened));


                // Hitung jumlah pemakaian per akun
                $count = array_count_values($flattened);


                // Filter akun yang belum melebihi batas
                $filtered = array_filter($count, function ($val, $id) use ($batas, $account) {
                    return $val < $batas && in_array($id, $account->toArray());
                }, ARRAY_FILTER_USE_BOTH);

               

                if (!empty($filtered)) {
                // Ambil ID akun pertama yang masih di bawah batas
                $next_available_id = array_key_first($filtered);
                return $next_available_id;
                } else {
                // Ambil akun yang belum pernah dipakai sama sekali
                $account_used = array_unique($flattened); // array 1 dimensi, jadi aman
                $id_akun_univ = UniversityAccount::where('university_id', $id_univ)
                    ->whereNotIn('id', $account_used)
                    ->pluck('id')
                    ->first();

                return $id_akun_univ ?? null;
                }
         
        }
    
    }


    public function pending(){

        try {
            $user = User::find(2);
            $data =[
                'name' => $user->name,
                'url' => route('/')
            ];
            Mail::to($user->email)->send(new pending($data));
            return "sukses";
        } catch (\Throwable $th) {
            return "gagal";
        }
       
    }

    public function expired(){
        try {
            $user = User::find(2);
            $data =[
                'name' => $user->name,
                'url' => route('/')
            ];
            Mail::to($user->email)->send(new expired($data));
            return "sukses";
        } catch (\Throwable $th) {
            return "gagal";
        }
    }
}

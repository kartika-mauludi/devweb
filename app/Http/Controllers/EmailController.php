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

        if($a = array_keys($akun, null, true)){
            // return $a;
            for($i = 0; $i < count($a); $i++){
                $univid = $univ_id[$a[$i]];
                $universiti[] = University::where('id',$univid)->pluck('name');
            }
            $data = $universiti;
            foreach ($data as $key => $value) {
              return  $data[$key] = $value;
            }
            // Mail::to('ludi@gmail.com')->send(new pending($data));
            // return "sukses";
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
        for($i = 0; $i <= $jumlah_akun; $i++){
            $id_akun_univ = UniversityAccount::where('university_id',$id_univ)->pluck('id')->first();
            return $id_akun_univ;
        }

    }else{      
        foreach ($user_akun as $id){
          foreach ($id as $i) {
            $akun_user[] = $i;
          }
        }
       $next_id = array_values(array_unique($akun_user));
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
                for($i = 0; $i <= $jumlah_akun; $i++){
                    $id_akun_univ = UniversityAccount::where('university_id',$id_univ)->pluck('id')->first();
                    return $id_akun_univ;
                }
            }
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

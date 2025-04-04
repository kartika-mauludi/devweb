<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Mail;
use App\Mail\invoice;
use App\Mail\pending;
use App\Mail\expired;
use App\Models\SubscribeRecord;

class EmailController extends Controller
{
    public function invoice(){

        $payment = Payment::latest('id')->where("user_id", 2)->first();
        $subscribe = SubscribeRecord::with("subscribePackage")->where("user_id", $payment->user_id)->first();
        $user = User::find(2);

        try {
          
            $data = [
                'name' => $user->name,
                'email'=> $user->email,
                'invoice_id' => $payment->id_invoice,
                'paket' => $subscribe->subscribePackage->name,
                'start_date' => $subscribe->start_date,
                'end_date' => $subscribe->end_date,
                'price' => $subscribe->subscribePackage->price,
                'status' => $payment->status
            ];
            Mail::to($user->email)->send(new invoice($data));
    
        } catch (\Throwable $th) {
            return "gagal";
        }

        return "sukses";
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

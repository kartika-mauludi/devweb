<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscribePackage;
use App\Models\SubscribeRecord;
use App\Models\Payment;
use Auth;
use Session;

class LanggananController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function langganan(){
        $id = Auth::user()->id;
        // return $id;
        $langganan = Payment::with('subscribeRecord.subscribePackage')->where('user_id',$id)->first();
    //    return $langganan;
        return view('customer.langganan.index',compact('langganan'));
    }

    public function upgrade(){
        $packages = SubscribePackage::all();
        return view('customer.langganan.upgrade',compact('packages'));
    }

    public function newsubscriber(Request $request){
        
        return session::get('id');
        $record = SubscribeRecord::where('user_id',Auth::user()->id)->first();
        $pack = SubscribePackage::where('id',Session::get('id'))->first();
        $a = $record->end_date->addDays($pack->days);
        return $a;

        if($record->end_date < now() ){
             $input = $request->except('_token');
            try {
                $record->update(['end_date' => $record->end_date->addDays($pack->days)]);
                $message = $this::$message['updatesuccess'];
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        elseif($record->end_date > now()){
            return "sudah exp";
        }
        // $input = $request->except('_token');
        // try {
        //     //code...
        // } catch (\Throwable $th) {
        //     //throw $th;
        // }
    }

    public function payment($id){
        $pack = SubscribePackage::where('id',$id)->first();
        return view('customer.langganan.payment',compact('pack'));
    }

}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscribePackage;
use App\Models\SubscribeRecord;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Auth;
use DB;
use Session;

class LanggananController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function langganan(){
        $id = Auth::user()->id;
        $langganans = Payment::with('subscribeRecord.subscribePackage')
        ->where('user_id',$id)
        ->whereHas('subscribeRecord', function ($query) {
            $query->where('account_status', 'aktif');
        })->get();
       if(count($langganans) >= 1){
        $langganan = Payment::latest('id')->with('subscribeRecord.subscribePackage')
        ->where('user_id',$id)
        ->whereHas('subscribeRecord', function ($query) {
            $query->where('account_status', 'aktif');
        })->first();
       }
       else{
        $langganan = Payment::latest('id')
        ->with('subscribeRecord.subscribePackage')
        ->where('user_id',$id)
       ->first();
       }
        return view('customer.langganan.index',compact('langganan'));
    }

    public function upgrade(){
        $packages = SubscribePackage::all();
        return view('customer.langganan.upgrade',compact('packages'));
    }

    public function newsubscriber(Request $request){
        

        $user = User::where('email',$request->email)->first();
        $latest = Payment::latest()->first();
        if (! $latest) {
            $string= '0000001';
        }else{
        $string = preg_replace("/[^0-9\.]/", '', $latest->id_invoice);
        }

             $input = $request->except('_token');
             DB::beginTransaction(); 
            try {
                $sub = SubscribeRecord::create([
                    'user_id'=> $user->id,
                    'subscribe_package_id' => Session::get('id_pack'),
                ]);

                $payment = Payment::create([
                    'user_id' => $user->id,
                    'subscribe_record_id' => $sub->id,
                    'id_invoice' => 'inv-'. sprintf('%06d', $string+1),
                    'price' => Session::get('price'),
                    'discount' => Session::get('discount'),
                    'status' => 'pending',
                    'order_id' => "ORD".rand()
                ]);
                DB::commit();
                
                return redirect()->route('customer/langganan.qris',$payment->user_id);
                // $datas['user'] = $user->id;
                // $datas['payment'] = $payment->id; 
                // $datas['sub'] = $sub->id;
                // $response = Http::post(route('subscribepayment'), $datas);
                // return $response;
                
            } catch (\Throwable $th) {
                report($th);
                $message = $this::$message['error_payment'];
                return back()->with('message', $message);
            }

    }

    public function payment($id){
        $pack = SubscribePackage::where('id',$id)->first();
        return view('customer.langganan.payment',compact('pack'));
    }

    public function qris($id){
        $user = User::where('is_superadmin',1)->first();
        $pack = SubscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->first();
        // return $pack;
        return view('customer.qris',compact('pack','user'));
        
    }

}

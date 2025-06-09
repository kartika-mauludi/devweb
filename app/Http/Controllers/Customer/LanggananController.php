<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscribePackage;
use App\Models\SubscribeRecord;
use App\Models\Payment;
use App\Models\User;
use App\Models\ConfigAdmin;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\re_register;
use Auth;
use DB;
use Session;
use Illuminate\Support\Str;

class LanggananController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
        $this->admin_email = User::with('config')->find(optional(ConfigAdmin::first())?->email)?->email;
        
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
                    'order_id' => rand()
                ]);
                DB::commit();

                $data["user"] = $user;
                $data["invoice"] = $payment->id_invoice;
                Mail::to($this->admin_email ?? "afibrulyansah@unusa.ac.id")->send(new re_register($data));
                
                return redirect()->route('customer/langganan.qris',$payment->user_id);
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
        $pack = SubscribeRecord::latest('id')->with('subscribePackage','payments')->where('user_id',$id)->first();
    
        return view('customer.qris',compact('pack','user'));
        
    }

    public function qris_response($id){
        $status = SubscribeRecord::select('account_status')->latest('id')->where('user_id',$id)->first();
        if ($status) {
            return response()->json([
                "status" => $status->account_status
            ]);
        } else {
            return response()->json([
                "status" => "non-aktif",
                "message" => "Data tidak ditemukan"
            ]);
        }
    }

}

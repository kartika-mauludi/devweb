<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribePackage;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use App\Models\Payment;
use App\Models\User;
use App\Models\SubscribeRecord;
use Midtrans\Snap;


class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('Midtrans.server_key');
        Config::$isProduction = config('Midtrans.is_production');
        Config::$isSanitized = config('Midtrans.is_sanitized');
        Config::$is3ds = config('Midtrans.is_3ds');
    }
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // $ref = request()->query('ref');
        $pack = SubscribePackage::where('id',$id)->first();
        return view('payment',compact('pack'));
    }

    public function subscribepayment(Request $request)
    {
        
        $user = User::where('id',$request->user)->first();
        $payment = Payment::find($request->payment);
        $sub = SubscribeRecord::with('subscribePackage')->where('id',$request->sub)->first();
        $params = array(
            "payment_type" => "qris",
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $sub->subscribePackage->price,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->nomor,
            ],
            'item_details' => [
                    "id" => $sub->subscribePackage->id,
                    "price" => $sub->subscribePackage->price,
                    "quantity" => 1,
                    "name" => $sub->subscribePackage->name
            ]
        );
           $auth = Base64_encode(env('MIDTRANS_SERVER_KEY')); 
           $response = Http::withHeaders([
            'Accept' => 'Application/json',
            'Content-Type' => 'Application/json',
            'Authorization' => "Basic $auth",
           ])->post('https://app.sandbox.midtrans.com/snap/v1/transactions',$params);
          
           $response = json_decode($response->body());
           $payment->order_id = $params['transaction_details']['order_id'];
           $payment->redirect_link = $response->redirect_url;
           $payment->save();

           
           $data['url'] = $response->redirect_url;
           return view('qris',$data);
     
    }

    public function qris(){
        $packages =  SubscribePackage::all();
        return view('qris',compact('packages'));
    }

    public function webhook(Request $request){
        $auth = Base64_encode(env('MIDTRANS_SERVER_KEY')); 
        $response = Http::withHeaders([
            'Content-Type' => 'Application/json',
            'Authorization' => "Basic $auth",
           ])->get("https://api.sandbox.midtrans.com/v2/$request->order_id/status");

           $payment = Payment::where("id",$response->order_id)->firstOrFail();

           if($payment->status === "settlement" || $payment->status === "capture"){
                return response()->json('payment berhasil');
            }

            if( $response->transaction_status === 'capture'){
                $payment->status = 'complete';

            } else if( $response->transaction_status === 'settlement'){
                $payment->status = 'complete';
            
            }else if( $response->transaction_status === 'pending'){
                $payment->status = 'pending';

            }else if( $response->transaction_status === 'expired'){
                $payment->status = 'failed';

            }
            return response()->json($response);   
    }

    public function callback(Request $request){
        return $request->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

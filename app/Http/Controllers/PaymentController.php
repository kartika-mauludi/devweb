<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribePackage;
use Illuminate\Support\Facades\Http;
use Midtrans\Config;
use App\Models\Payment;
use App\Models\User;
use App\Models\SubscribeRecord;
use App\Models\MidtranConfig;
use Illuminate\Support\Facades\Mail;
use App\Mail\invoice;
use App\Mail\expired;
use App\Mail\pending;
use Auth;
use Midtrans\Snap;
use Arr;


class PaymentController extends Controller
{
    protected $server_key;
    protected $client_key;
    public function __construct()
    {
        $midtras = MidtranConfig::first(); 

        if (!$midtras) {
            $message = $this::$message['error'];
            return back()->with('message',$message);
        }

        Config::$serverKey = $midtras->environment === 'production'
        ? $midtras->production_server_key
        : $midtras->sandbox_server_key;

        Config::$clientKey = $midtras->environment === 'production'
        ? $midtras->production_client_key
        : $midtras->sandbox_client_key;
    
        if ($midtras->environment === "sandbox") {
            $server_key = $midtras->sandbox_server_key;
            $client_key = $midtras->sandbox_client_key;
            $url = "https://app.sandbox.midtrans.com/snap/v1/transactions";
        } elseif ($midtras->environment === "production") {
            $server_key = $midtras->production_server_key;
            $client_key = $midtras->production_client_key;
            $url = "https://app.midtrans.com/snap/v1/transactions";
        } else {
            abort(500, 'Invalid environment value in Midtrans configuration');
        }
    
        $this->server_key = $server_key;
        $this->client_key = $client_key;
        $this->url = $url;
    }
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $pack = SubscribePackage::where('id',$id)->first();
        return view('payment',compact('pack'));
    }

    public function subscribepayment(Request $request)
    {
        try {
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
               $auth = Base64_encode($this->server_key.":"); 
               $response = Http::withHeaders([
                'Accept' => 'Application/json',
                'Content-Type' => 'Application/json',
                'Authorization' => "Basic $auth",
               ])->post($this->url,$params);
               $response = json_decode($response->body());
               $payment->order_id = $params['transaction_details']['order_id'];
               $payment->redirect_link = $response->redirect_url;
               $payment->save();
               $data['url'] = $response->redirect_url;
               return view('qris',$data);
               
        } catch (\Throwable $th) {
            report($th);
            $error = $this::$message['error_payment'];
            Auth::loginUsingId($request->user);
            return redirect()->route('customer.home')->with('message', $error);
        }
       
     
    }

    public function qris(){
        $packages =  SubscribePackage::all();
        return view('qris',compact('packages'));
    }

    public function webhook(Request $request){
        $auth = Base64_encode($this->server_key.":"); 
        $response = Http::withHeaders([
            'Content-Type' => 'Application/json',
            'Authorization' => "Basic $auth",
           ])->get("https://api.sandbox.midtrans.com/v2/$request->order_id/status");
           $response = json_decode($response->body(),true);
           return $this->paymentcek($response); 
    }


    public function paymentcek(array $response){
           $jmlsub = 0;
           $payment = Payment::where("order_id",$response['order_id'])->first();
           $sub = SubscribeRecord::where('user_id',$payment->user_id)->get();
           $user = User::find($payment->user_id);
           if($payment->status === "settlement" || $payment->status === "capture"){
                return response()->json('payment berhasil');
            }

            if(count($sub) > 1){
                $jmlsub = count($sub)-2;
            }

            $status = $response['transaction_status'];

            if( $status === 'capture'){
                $payment->status = 'completed';
                $message = $this::$message['sukses'];

            } else if( $status === 'settlement'){

                $payment->status = 'completed';
                SubscribeRecord::where('user_id', $payment->user_id)
                ->update(['account_status' => 'non-aktif']);
                $subcribe = SubscribeRecord::where('id',$payment->subscribe_record_id)->first();
                $pack = SubscribePackage::where('id',$subcribe->subscribe_package_id)->first();
                $subcribe->start_date = now();
                $subcribe->end_date = now()->addDays($pack->days);
                $subcribe->account_status = "aktif";
                $subcribe->save();
                $data = [
                    'name' => $user->name,
                    'email'=> $user->email,
                    'invoice_id' => $payment->id_invoice,
                    'paket' => $subcribe->subscribePackage->name,
                    'start_date' => $subcribe->start_date,
                    'end_date' => $subcribe->end_date,
                    'price' => $subcribe->subscribePackage->price,
                    'status' => $payment->status
                ];
                Mail::to($user->email)->send(new invoice($data));
                $message = $this::$message['sukses'];

            }else if( $status === 'pending'){
                $data =[
                    'name' => $user->name
                ];
                Mail::to($user->email)->send(new pending($data));

                $payment->status = 'pending';
                $message = $this::$message['error'];

            }else if( $status === 'expire'){
                $data =[
                    'name' => $user->name
                ];
                Mail::to($user->email)->send(new expired($data));
                $payment->status = 'failed';
                $message = $this::$message['error'];
            }
            $payment->save();

            return redirect()->route('customer.home')->with('message', $message);
    }

    public function callback(Request $request){
        $jmlsub = 0;
        $payment = Payment::where("order_id",$request->order_id)->first();
        $sub = SubscribeRecord::where('user_id',$payment->user_id)->get();
        $user = User::find($payment->user_id);
      
        if(count($sub) > 1){
            $jmlsub = count($sub)-2;
        }
        if( $request->transaction_status === 'capture'){
            $payment->status = 'completed';

        } else if( $request->transaction_status === 'settlement'){
            $payment->status = 'completed';
            SubscribeRecord::where('user_id', $payment->user_id)
            ->update(['account_status' => 'non-aktif']);
            
            $subcribe = SubscribeRecord::where('id',$payment->subscribe_record_id)->first();
            $pack = SubscribePackage::where('id',$subcribe->subscribe_package_id)->first();
            $subcribe->start_date = now();
            $subcribe->end_date = now()->addDays($pack->days);
            $subcribe->account_status = "aktif";
            $subcribe->save();
            $data = [
                'name' => $user->name,
                'email'=> $user->email,
                'invoice_id' => $payment->id_invoice,
                'paket' => $subcribe->subscribePackage->name,
                'start_date' => $subcribe->start_date,
                'end_date' => $subcribe->end_date,
                'price' => $subcribe->subscribePackage->price,
                'status' => $payment->status
            ];
            Mail::to($user->email)->send(new invoice($data));
            $message = $this::$message['sukses'];

        }else if( $request->transaction_status === 'pending'){
            $data =[
                'name' => $user->name
            ];
            Mail::to($user->email)->send(new pending($data));

            $payment->status = 'pending';

        }else if( $request->transaction_status === 'expired'){

            $data =[
                'name' => $user->name
            ];
            Mail::to($user->email)->send(new expired($data));

            $payment->status = 'failed';

        }
        $payment->save();

        return redirect()->route('customer.home')->with('message', $message);
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
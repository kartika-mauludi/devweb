<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use app\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\SubscribeRecord;
use App\Models\Payment;
use Carbon\Carbon;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function __construct()
     {
         $this->middleware('user');
     }
    public function index()
    {
        //
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
        $url = route('customer/profil.update',$id);
        $passurl =  route('customer/profil.password',$id);
        $user = User::with('payments')->where('id',$id)->first();
        $subscribes = subscribeRecord::with('subscribePackage')->where('user_id',$id)->get();
        return view('customer.profil',compact('user','url','passurl','subscribes'));
        
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
    public function update(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $user->update([
            'name'  => $request->name,
            'nomor' => $request->nomor,
            'bank_account' => $request->rekening,
            'bank_name' => $request->bank
        ]);
        if($user){
            return back ()->with(['message'=> 'Data Berhasil Diubah','active' => 1]);
        }
        else{
            return back ()->with(['error'=>'Ada Kesalahan Silahkan Hubungi Admin','active' => 1]);
        }
       
    }

 
    public function password(Request $request, $id){
        // return $request->input();
        $user = User::where('id',$id)->first();
        if (Hash::check($request->passwordold, $user->password)) { 
           
            $validator = Validator::make($request->input(), [
                'passwordold' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed','different:passwordold'],
            ],
            [
                'password.confirmed' => 'Password tidak sama dengan password konfirmasi',
                'password.different' => 'Password baru tidak boleh sama dengan password lama',
                'password.required' => 'Password baru tidak boleh kosong',
                'passwordold.required' => 'Password lama tidak boleh kosong',
            ]);

            if($validator->fails()) {
                return back ()->with(['active' => 2])->withErrors($validator);
            }
            
             $user->update([
            'password' => Hash::make($request['password'])
        ]);
             return back ()->with(['message' => 'Password Berhasil Diubah','active' => 2]);
         }
         else {
            return back ()->with(['error'=>'Password Lama Salah','active' => 2]);
        }
      
       
    }

    public function invoice($id){
        $payment = Payment::latest('id')->where("user_id", $id)->first();
        $subscribe = SubscribeRecord::with("subscribePackage")->where("user_id", $payment->user_id)->first();
        $user = User::find($id);

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

        return view("customer.invoice",$data);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
     
    }
}

<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserAffiliate;
use App\Models\AffiliateComission;
use App\Models\Payment;
use App\Models\User;
use auth;
use DB;


class AffiliasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function affiliasi(){

        $data['komisi'] = AffiliateComission::latest()->first();
        $data['pending'] = UserAffiliate::whereHas('payments', function($query){$query->where('status','pending');})->where('User_id',auth::user()->id)->get();
        $data['pendingwd'] = UserAffiliate::latest('id')->where('user_id',auth::user()->id)->where('status','withdraw')->first();
        $data['paid'] = UserAffiliate::whereHas('payments', function($query){$query->where('status','completed');})->where('User_id',auth::user()->id)->get();
        $data['wd'] = UserAffiliate::with('user')->where('user_id',auth::user()->id)->where('status','withdraw')->get();
        $data['refferal'] = User::where('id',auth::user()->id)->first();
        // return $data['refferal'];
        return view('customer.affiliasi.index',$data);
   
       
    }

    public function store(Request $request){
        $amount = preg_replace('/[^0-9]+/', '', $request->amount);
        $input = $request->except('_token');
        try {
            UserAffiliate::Create(['user_id' => auth::user()->id, 'status'=>'withdraw','amount'=>$amount], $input);
            $message = $this::$message['createsuccess'];
        } catch (\Throwable $th) {
            report($th);
            $message = $this::$message['error'];
        }

        return back()->with(['message'=>$message, 'amount' =>$amount]);
    }

 



}

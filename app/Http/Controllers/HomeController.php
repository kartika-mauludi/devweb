<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribeRecord;
use auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\SubscribePackage;
use App\Models\UserAffiliate;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

     public function index(){
        // $packages =  SubscribePackagecribe::all();
        return view('welcome');
     }

    public function adminhome()
    {
        return view('admin.home');
    }

    public function userhome()
    {
        $id = auth::user()->id;
        $user =  User::with('subscribeRecord.subscribePackage')->find($id);
        $subscribes = subscribeRecord::with('subscribePackage')->where('user_id',$id)->latest('id')->first();
        $paid = UserAffiliate::whereHas('payments', function($query){$query->where('status','completed');})->where('User_id',auth::user()->id)->get();
        $wd= UserAffiliate::with('user')->where('user_id',auth::user()->id)->where('status','withdraw')->get();
        $payment = Payment::where('user_id',$id)->first();
        $data['user'] = $user;
        $data['komisi'] = $paid->sum('amount') - $wd->sum('amount') ;
        $data['sub'] = $subscribes;
        $data['payment'] = $payment;
        
        return view('customer.home',$data);
    }

   

}

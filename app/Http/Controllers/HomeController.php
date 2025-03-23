<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribeRecord;
use auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\SubscribePackage;

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
        $subscribes = subscribeRecord::with('subscribePackage')->where('user_id',$id)->get();
        foreach($subscribes as $subscribe){
          $sub =  $subscribe->subscribepackage->name;
        }
        return view('customer.home',compact('user','sub'));
    }


}

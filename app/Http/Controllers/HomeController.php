<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribeRecord;
use auth;
use App\Models\User;
use App\Models\Payment;
use App\Models\SubscribePackage;
use App\Models\UserAffiliate;
use App\Models\University;
use App\Models\UniversityAccount;
use App\Models\UniversityWebsite;
use App\Models\Website;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     private $title = 'Dashboard';
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
        $data['title'] = $this->title;
        $data['activeCustomer'] = User::customer()->whereHas('subscribeRecord', function($query) {
            $query->where('end_date', '>', date('Y-m-d'));
        })->get();
        $data['inactiveCustomer'] = User::whereHas('subscribeRecord', function($query) {
            $query->where('end_date', '<=', date('Y-m-d'));
        })->ordoesntHave('subscribeRecord')->customer()->get();
        $data['incomes'] = Payment::where('status', 'completed')->get();
        $data['withdrawRequest'] = UserAffiliate::where('status', 'pending')->get();

        return view('admin.dashboard.index', $data);
    }

    public function userhome()
    {
        $id = auth::user()->id;
        $user =  User::with('subscribeRecord.subscribePackage')->find($id);
        $subscribe = subscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->where('account_status','aktif')->get();
        if(count($subscribe)  >= 1){
            $subscribes = subscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->where('account_status','aktif')->first();
        }
        else{
            $subscribes = subscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->first();
        }
        $paid = UserAffiliate::whereHas('payments', function($query){$query->where('status','completed');})->where('User_id',auth::user()->id)->get();
        $wd= UserAffiliate::with('user')->where('user_id',auth::user()->id)->where('status','withdraw')->get();
        $payment = Payment::latest('id')->where('user_id',$id)->first();
        $admin = User::where('is_superadmin',1)->first();
        $univ = University::all();
        $website = UniversityWebsite::with('university')->get();
        $akun = [];
        if ($user['akun_id']) {
            $akun = UniversityAccount::with('university')->wherein('id',$user->akun_id)->get();
        }

        $data['admin'] = $admin;
        $data['user'] = $user;
        $data['komisi'] = $paid->sum('amount') - $wd->sum('amount') ;
        $data['sub'] = $subscribes;
        $data['payment'] = $payment;
        $data['univs'] = $univ;
        $data['websites'] = $website;
        $data['akuns'] = $akun;
        
        return view('customer.home',$data);
    }

   

}

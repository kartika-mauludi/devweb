<?php

namespace App\Http\Controllers;

use App\Models\BonusesDetails;
use Illuminate\Http\Request;
use App\Models\SubscribeRecord;
use auth;
use App\Models\User;
use App\Models\File;
use App\Models\Payment;
use App\Models\SubscribePackage;
use App\Models\UserAffiliate;
use App\Models\University;
use App\Models\UniversityAccount;
use App\Models\UniversityWebsite;
use App\Models\Website;
use App\Models\Bonus;



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
        $data['unpaid'] = User::whereHas('payments', function($query) {
            $query->where('status', '=', "pending");
        })->get();
        $data['incomes'] = Payment::where('status', 'completed')->get();
        $data['withdrawRequest'] = UserAffiliate::where('status', 'withdraw')->get();

        return view('admin.dashboard.index', $data);
    }

    public function userhome()
    {
        $id = auth::user()->id;
        $user =  User::with('subscribeRecord.subscribePackage')->find($id);
        $subscribe = SubscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->where('account_status','aktif')->get();
        if(count($subscribe)  >= 1){
            $subscribes = SubscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->where('account_status','aktif')->first();
        }
        else{
            $subscribes = SubscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->first();
        }
        $ceksub = subscribeRecord::latest('id')->with('subscribePackage')->where('user_id',$id)->first();;
        $paid = UserAffiliate::select('amount')->whereHas('payments', function($query){$query->where('status','completed');})->where('User_id',auth::user()->id)->get();
        $wd= UserAffiliate::select('amount')->with('user')->where('user_id',auth::user()->id)->where('status','withdraw')->get();
        $payment = Payment::latest('id')->where('user_id',$id)->first();
        $admin = User::where('is_superadmin',1)->first();
        $univ = University::where('parent','==',0)->where('parent','===',Null)->get();
        $website = UniversityWebsite::with('university')->orderBy('title')->get();
        $file = File::latest()->get();
        $bonus_global = Bonus::where('type','=','global')->first();
        $bonus_private = BonusesDetails::with('bonus')->where('user_id', Auth::id())->first();

        $data['admin'] = $admin;
        $data['user'] = $user;
        $data['komisi'] = $paid->sum('amount') - $wd->sum('amount') ;
        $data['sub'] = $subscribes;
        $data['payment'] = $payment;
        $data['univs'] = $univ;
        $data['websites'] = $website;
        $data['ceksub'] = $ceksub;
        $data['files'] = $file;
        $data['bonus_global'] = $bonus_global;
        $data['bonus'] = $bonus_private;

        
        return view('customer.home',$data);
    }



}
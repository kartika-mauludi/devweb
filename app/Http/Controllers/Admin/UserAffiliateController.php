<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAffiliate;
use App\Models\ConfigAdmin;
use Illuminate\Support\Facades\Mail;
use App\Mail\withdraw_success;
use Exception;
use Illuminate\Http\Request;

class UserAffiliateController extends Controller
{
    private $title = 'Master Widthraw';

    public function __construct()
    {
        $this->middleware('admin');
        $this->admin_email = User::with('config')->find(optional(ConfigAdmin::first())?->email)?->email;

    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = UserAffiliate::latest()->where("status","=","withdraw")->get();
        $data['success'] = UserAffiliate::latest()->where("status","=","success")->get();
    //    return $data['records'];
        return view('admin.user-affiliates.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('user-affiliates.store');
        $data['prev']  = route('user-affiliates.index');
        $data['customers'] = User::customer()->get();

        return view('admin.user-affiliates.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        try{
            UserAffiliate::create($input);
            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('user-affiliates.index')->with('message', $message);
    }

    public function show(UserAffiliate $userAffiliate)
    {
        $data['title']  = $this->title;
        $data['url']   = route('user-affiliates.edit', $userAffiliate->id);
        $data['prev']  = route('user-affiliates.index');
        $data['record'] = $userAffiliate;

        return view('admin.user-affiliates.show', $data);
    }

    public function edit(UserAffiliate $userAffiliate)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('user-affiliates.update', $userAffiliate->id);
        $data['prev']  = route('user-affiliates.index');
        $data['customers'] = User::customer()->get();
        $data['record']= $userAffiliate;

        return view('admin.user-affiliates.form', $data);
    }

    public function update(Request $request, UserAffiliate $userAffiliate)
    {
        $input = $request->except('_token', '_method');

        try{
            $userAffiliate->update($input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('user-affiliates.index')->with('message', $message);
    }

    public function proceed(UserAffiliate $userAffiliate)
    {

        $input['status'] = 'success';
        
        try{
            $email = User::with('affiliates')->where('id','=',$userAffiliate->user_id)->first()->email;
            $userAffiliate->update($input);
            $message = $this::$message['updatesuccess'];
            $data["amount"] = $userAffiliate->amount;
            Mail::to($email)->send(new withdraw_success($data));

        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('user-affiliates.index')->with('message', $message);
    }

    public function destroy(UserAffiliate $userAffiliate)
    {
        try{
            $userAffiliate->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('user-affiliates.index')->with('message', $message);
    }
}

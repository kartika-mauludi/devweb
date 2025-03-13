<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubscribePackagecribe;

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
        return view('user.home');
    }


}

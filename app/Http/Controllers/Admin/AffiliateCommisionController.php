<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateComission;
use Exception;
use Illuminate\Http\Request;

class AffiliateCommisionController extends Controller
{
    private $title = 'Konfigurasi Komisi';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function setting()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('commision-config.store');
        $data['prev']  = route('configuration');
        $data['record']= AffiliateComission::latest()->first();

        return view('admin.komisi.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token', 'Id');

        try{
            AffiliateComission::updateOrCreate(['id' => $request->Id], $input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('configuration')->with('message', $message);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SubscribeRecord;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $title = 'Master Pembayaran';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = Payment::all();

        return view('admin.payment.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('payment.store');
        $data['prev']  = route('payment.index');
        $data['subscribeRecords'] = SubscribeRecord::all();

        return view('admin.payment.form', $data);
    }

    public function store(Request $request)
    {
        $subscribeRecord = SubscribeRecord::find($request->subscribe_record_id);
        $input = $request->except('_token');
        $input['user_id'] = $subscribeRecord->user_id;
        $input['discount']= ($request->filled('discount')) ? $request->discount : 0;

        try{
            Payment::create($input);

            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }

    public function show(Payment $payment)
    {
        $data['title']  = $this->title;
        $data['url']   = route('payment.edit', $payment->id);
        $data['prev']  = route('payment.index');
        $data['record'] = $payment;

        return view('admin.payment.show', $data);
    }

    public function edit(Payment $payment)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('payment.update', $payment->id);
        $data['prev']  = route('payment.index');
        $data['subscribeRecords'] = SubscribeRecord::all();
        $data['record']= $payment;

        return view('admin.payment.form', $data);
    }

    public function update(Request $request, Payment $payment)
    {
        $subscribeRecord = SubscribeRecord::find($request->subscribe_record_id);
        $input = $request->except('_token', '_method');
        $input['user_id'] = $subscribeRecord->user_id;
        $input['discount']= ($request->filled('discount')) ? $request->discount : 0;
        
        try{
            $payment->update($input);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }

    public function destroy(Payment $payment)
    {
        try{
            $payment->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('payment.index')->with('message', $message);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscribePackage;
use App\Models\SubscribeRecord;
use App\Models\User;
use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SubscribeRecordController extends Controller
{
    private $title = 'Master Langganan';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = SubscribeRecord::latest()->get();

        return view('admin.package-record.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('package-record.store');
        $data['prev']  = route('package-record.index');
        $data['customers'] = User::customer()->get();
        $data['packages']  = SubscribePackage::all();

        return view('admin.package-record.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');

        try{
            SubscribeRecord::create($input);
            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('package-record.index')->with('message', $message);
        
    }

    public function show(SubscribeRecord $subscribeRecord)
    {
        $data['title']  = $this->title;
        $data['url']   = route('package-record.edit', $subscribeRecord->id);
        $data['prev']  = route('package-record.index');
        $data['record'] = $subscribeRecord;

        return view('admin.package-record.show', $data);
    }

    public function edit(SubscribeRecord $subscribeRecord)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('package-record.update', $subscribeRecord->id);
        $data['prev']  = route('customer.show', $subscribeRecord->user_id);
        $data['customers'] = User::customer()->get();
        $data['packages']  = SubscribePackage::all();
        $data['record']= $subscribeRecord;

        return view('admin.package-record.form', $data);
    }

    public function update(Request $request, SubscribeRecord $subscribeRecord)
    {
        $input = $request->except('_token', '_method');
       
        try{
            SubscribeRecord::where('user_id',$subscribeRecord->user_id)->update([
                'account_status' => 'non-aktif'
            ]);

            $package = SubscribePackage::find($request->subscribe_package_id);
            $start = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $end   = $start->copy()->addDays((int) $package->days);

            $subscribe = SubscribeRecord::create([
                'user_id' => $request->user_id,
                'subscribe_package_id' => $request->subscribe_package_id,
                'start_date' => $start,
                'end_date' => $end,
                'account_status' => 'aktif'
            ]);
            $latest = Payment::latest()->first();
            if (! $latest) {
                $string= '0000001';
            }else{
                $string = preg_replace("/[^0-9\.]/", '', $latest->id_invoice);
            }
            $payment['user_id'] = $request->user_id;
            $payment['subscribe_record_id'] = $subscribe->id;
            $payment['id_invoice'] = 'inv-'. sprintf('%06d', $string+1);
            $payment['price'] = $package->price;
            $payment['status'] = 'completed';

            Payment::create($payment);

         

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.show', $subscribeRecord->user_id)->with('message', $message);
    }

    public function destroy(SubscribeRecord $subscribeRecord)
    {
        try{
            $subscribeRecord->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.show', $subscribeRecord->user_id)->with('message', $message);
    }
}

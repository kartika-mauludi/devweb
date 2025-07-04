<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SubscribePackage;
use App\Models\SubscribeRecord;
use App\Models\UniversityAccount;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PhpParser\Node\Stmt\TryCatch;

class CustomerController extends Controller
{
    private $title = 'Master Customer';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title']   = $this->title;
        $data['records'] = User::customer()->latest()->get();

        return view('admin.customer.index', $data);
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['label'] = 'Tambah';
        $data['url']   = route('customer.store');
        $data['prev']  = route('customer.index');
        $data['packages'] = SubscribePackage::all();
        return view('admin.customer.form', $data);
    }

    public function store(Request $request)
    {
        $input = $request->except('_token');
        $input['referral_code'] = Str::random(3).str_replace('-', '', (string) Str::uuid());
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        DB::beginTransaction();
        try{
            $user = User::create($input);
            $package = SubscribePackage::find($request->package_id);
            $start = Carbon::createFromFormat('Y-m-d', $request->start_date);
            $end   = $start->copy()->addDays((int) $package->days);
            
            if ($package) {
                $subs['user_id'] = $user->id;
                $subs['subscribe_package_id'] = $package->id;
                $subs['start_date'] = $start;
                $subs['end_date'] = $end;
                $subs['account_status'] = 'aktif';
    
                $subsrecord = SubscribeRecord::create($subs);
                $latest = Payment::latest()->first();
                if (! $latest) {
                    $string= '0000001';
                }else{
                    $string = preg_replace("/[^0-9\.]/", '', $latest->id_invoice);
                }
                $payment['user_id'] = $user->id;
                $payment['subscribe_record_id'] = $subsrecord->id;
                $payment['id_invoice'] = 'inv-'. sprintf('%06d', $string+1);
                $payment['price'] = $package->price;
                $payment['status'] = 'completed';

                Payment::create($payment);
            }

            DB::commit();
            $message = $this::$message['createsuccess'];
        }catch(Exception $x){
            DB::rollBack();
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }

    public function show(User $user)
    {
        $data['title']  = $this->title;
        $data['url']   = route('customer.edit', $user->id);
        $data['prev']  = route('customer.index');
        $data['record'] = $user;
        $data['subscribes'] = SubscribeRecord::where('user_id', $user->id)->latest()->get();

        if (request()->ajax()) {
            return response()->json($user);
        }

        return view('admin.customer.show', $data);
    }

    public function edit(User $user)
    {
        $data['title'] = $this->title;
        $data['label'] = 'Update';
        $data['url']   = route('customer.update', $user->id);
        $data['prev']  = route('customer.index');
        $data['record']= $user;
        $data['packages'] = SubscribePackage::all();
        $data['subscribe'] = SubscribeRecord::where('user_id','=',$user->id)->latest()->first();

        return view('admin.customer.form', $data);
    }

    public function update(Request $request, User $user)
    {
        $input = $request->except('_token', '_method', 'password');
        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        try{
            $user->update($input);
            $package = SubscribePackage::find($request->package_id);

            if ($package) {
                $start = Carbon::createFromFormat('Y-m-d', $request->start_date);
                $end   = $start->copy()->addDays((int) $package->days);
                $subs['start_date'] = $start;
                $subs['end_date'] = $end;
    
                
                $subscribe = SubscribeRecord::where('user_id','=',$user->id)->latest('id')->first();
                $subsrecord =  $subscribe->update([
                    'user_id' => $user->id,
                    'subscribe_package_id' => $package->id,
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
                $payment['user_id'] = $user->id;
                $payment['subscribe_record_id'] = $subscribe->id;
                $payment['id_invoice'] = 'inv-'. sprintf('%06d', $string+1);
                $payment['price'] = $package->price;
                $payment['status'] = 'completed';

                Payment::create($payment);
            }
            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }

    public function destroy(User $user)
    {
        try{
            $user->delete();

            $message = $this::$message['deletesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }

    public function akun(User $user)
    {
        $akun_universitas = UniversityAccount::all();

        foreach ($akun_universitas as $akun) {
            $akun_id = $user->akun_id ?? [];

            $data[] = array(
                'akun_id' => $akun->id,
                'akun_name' => $akun->university->name,
                'akun_username' => $akun->username,
                'selected' => (is_array($akun_id) && in_array($akun->id, $akun_id)) ? true : false
            );
        }

        return $data;
    }

    public function akunUpdate(Request $request, User $user)
    {   
        if (!$request->has('akun') or $request->akun == null) {
            return redirect()->route('customer.index');
        }

        foreach ($request->akun as $akun) {
            $akuns[] = (int) $akun;
        }

        try{
            $user->update([
                'akun_id' => $akuns
            ]);

            $message = $this::$message['updatesuccess'];
        }catch(Exception $x){
            report($x);
            $message = $this::$message['error'];
        }

        return redirect()->route('customer.index')->with('message', $message);
    }

    public function refresh(){

        try {
            user::with('latestSubscribeRecord')->where('is_superadmin','=','0')->whereHas('latestSubscribeRecord',
            function ($query) {$query->whereNotNull('end_date')->where('end_date', '<', now()); })
            ->update([
                'akun_id' => ''
            ]);
            $message = $this::$message['refreshsuccess'];
        } catch (\Throwable $th) {
            report($th);
            $message = $this::$message['error'];
        }
        return redirect()->route('customer.index')->with('message', $message);
    }
}

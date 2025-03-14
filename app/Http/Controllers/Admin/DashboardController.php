<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserAffiliate;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $title = 'Dashboard';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
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
}

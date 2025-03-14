<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateComission;
use Illuminate\Http\Request;

class ConfigurationController extends Controller
{
    private $title = 'Master Konfigurasi';

    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data['title'] = $this->title;
        $data['commisions'] = AffiliateComission::latest()->first();

        return view('admin.configuration.index', $data);
    }
}

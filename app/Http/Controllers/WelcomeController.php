<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Models\SubscribePackage;
use App\Models\UniversityWebsite;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $packages = SubscribePackage::get();
        $websites = UniversityWebsite::with('university')->orderBy('title')->get();
        $features = Feature::get();
        return view('welcome',compact('packages','websites','features'));
    }
}

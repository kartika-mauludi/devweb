<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PdfController extends Controller
{
    public function download($id){
        return view("customer.invoice");
    }
}

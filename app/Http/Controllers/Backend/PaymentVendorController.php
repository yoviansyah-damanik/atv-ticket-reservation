<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentVendorController extends Controller
{
    public function index()
    {
        return view('backend.pages.payment-vendor.index');
    }
}

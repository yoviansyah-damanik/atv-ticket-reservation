<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Package;

class HomeController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        $packages = Package::all();

        return view('frontend.pages.home.index', compact('units', 'packages'));
    }
}

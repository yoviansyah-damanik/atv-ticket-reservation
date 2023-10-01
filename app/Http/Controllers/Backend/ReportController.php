<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function unit(): View
    {
        return view('backend.pages.report.unit');
    }

    public function reservation(): View
    {
        return view('backend.pages.report.reservation');
    }

    public function revenue(): View
    {
        return view('backend.pages.report.revenue');
    }
}

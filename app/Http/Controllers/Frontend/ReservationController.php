<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class ReservationController extends Controller
{
    public function index()
    {
        return view('frontend.pages.reservation.index');
    }
}

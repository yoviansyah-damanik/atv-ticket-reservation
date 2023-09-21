<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Frontend\ReservationRequest;
use App\Models\ReservationDetail;

class ReservationController extends Controller
{
    public function index()
    {
        return view('frontend.pages.reservation.index');
    }

    public function store(ReservationRequest $request)
    {
        DB::beginTransaction();
        try {
            $new_reservation = new Reservation();
            $new_reservation->user_id = Auth::id();
            $new_reservation->date = $request->date;
            $new_reservation->time = $request->time;
            $new_reservation->save();

            $new_detail_reservation = new ReservationDetail();
            $new_detail_reservation->reservation_id = $new_reservation->id;
            $new_detail_reservation->unit_id = 1;
            $new_detail_reservation->package_id = 1;
            $new_detail_reservation->amount = 1;
            $new_detail_reservation->price = 1;
            $new_detail_reservation->save();

            Alert::success();
            return to_route('account.history.show', $new_reservation->id);
        } catch (Exception $e) {
            DB::rollBack();
            Alert::warning(__('Warning!'), $e->getMessage());
            return back();
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::warning(__('Warning!'), $e->getMessage());
            return back();
        }
    }
}

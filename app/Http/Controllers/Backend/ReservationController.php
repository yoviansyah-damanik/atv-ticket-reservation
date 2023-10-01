<?php

namespace App\Http\Controllers\Backend;

use Exception;
use Throwable;
use App\Models\Unit;
use App\Enums\UnitType;
use App\Models\Payment;
use App\Enums\PaymentType;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Enums\ReservationType;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Reservation\UnitReservationRequest;
use App\Models\UnitUsage;
use RealRashid\SweetAlert\Facades\Alert;

class ReservationController extends Controller
{
    public function index()
    {
        return view('backend.pages.reservation.index');
    }

    public function show(Reservation $reservation)
    {
        $units = Unit::where('status', UnitType::Ready)
            ->get();

        return view('backend.pages.reservation.show', compact('reservation', 'units'));
    }

    public function confirm_payment(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            $reservation->update(['status' => ReservationType::ReadyForAction]);
            if ($reservation->payment)
                $reservation->payment->update(['status' => PaymentType::PaidOff]);
            else
                Payment::create([
                    'reservation_id' => $reservation->id,
                    'payment_vendor_id' => 1,
                    'status' => PaymentType::PaidOff
                ]);

            DB::commit();
            Alert::toast(__('The :feature was successfully updated.', ['feature' => __('Reservation')]), 'success');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'warning');
            return back();
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'warning');
            return back();
        }
    }

    public function cancel(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            $reservation->update(['status' => ReservationType::Canceled]);
            if ($reservation->payment)
                $reservation->payment->update(['status' => PaymentType::WaitingForConfirmation]);

            DB::commit();
            Alert::toast(__('The :feature was successfully updated.', ['feature' => __('Reservation')]), 'success');
            return back();
        } catch (Exception $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'warning');
            return back();
        } catch (Throwable $e) {
            DB::rollBack();
            Alert::toast($e->getMessage(), 'warning');
            return back();
        }
    }

    public function confirmation(Reservation $reservation)
    {
        try {
            if ($reservation?->payment?->status != 'paid_off') {
                Alert::toast(__('Please confirm payment first.'), 'warning');
                return back();
            }

            if (!$reservation->unit_usages || ($reservation?->unit_usages->count() != $reservation->details->sum('amount'))) {
                Alert::toast(__('Please complete your unit selection first.'), 'warning');
                return back();
            }

            $reservation->update(['status' => ReservationType::Completed]);

            Alert::toast(__('The :feature was successfully updated.', ['feature' => __('Reservation')]), 'success');
        } catch (Exception $e) {
            Alert::toast($e->getMessage(), 'warning');
        } catch (Throwable $e) {
            Alert::toast($e->getMessage(), 'warning');
        }
        return back();
    }

    public function set_unit(UnitReservationRequest $request, Reservation $reservation)
    {
        try {
            UnitUsage::where('reservation_id', $reservation->id)
                ->delete();

            foreach ($request->selected_units as $selected) {
                UnitUsage::create([
                    'reservation_id' => $reservation->id,
                    'unit_id' => $selected
                ]);
            }

            Alert::toast(__('The :feature was successfully updated.', ['feature' => __('Reservation')]), 'success');
        } catch (Exception $e) {
            Alert::toast($e->getMessage(), 'warning');
        } catch (Throwable $e) {
            Alert::toast($e->getMessage(), 'warning');
        }
        return back();
    }
}

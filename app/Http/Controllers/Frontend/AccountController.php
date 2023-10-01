<?php

namespace App\Http\Controllers\Frontend;

use Exception;
use Throwable;
use App\Models\User;
use App\Models\Payment;
use Illuminate\View\View;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\PaymentVendor;
use App\Enums\ReservationType;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AccountRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\PasswordRequest;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\Reservation\PaymentRequest;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('frontend.pages.account.index');
    }

    public function history(): View
    {
        return view('frontend.pages.account.history.index');
    }

    public function show_history(Reservation $reservation): View
    {
        $next = Reservation::where('created_at', '<', $reservation->created_at)
            ->where('user_id', Auth::id())
            ->first();
        $previous = Reservation::where('created_at', '>', $reservation->created_at)
            ->where('user_id', Auth::id())
            ->first();

        $payment_vendors = PaymentVendor::all();
        $reservation->load('details', 'payment');
        return view('frontend.pages.account.history.show', compact('reservation', 'next', 'previous', 'payment_vendors'));
    }

    public function update_payment(PaymentRequest $request, Reservation $reservation): RedirectResponse
    {
        try {
            $new_payment = Payment::firstOrNew(
                [
                    'reservation_id' => $reservation->id
                ]
            );
            $new_payment->payment_vendor_id = $request->selected_payment_vendor;
            if ($request->proof_of_payment) {
                $filename = $request->proof_of_payment->store('proof-of-payment', 'public');
                $new_payment->proof_of_payment = $filename;
            }
            $new_payment->save();

            Alert::success(__('Successfully!'), __('Your payment has been successfully updated. Please wait for confirmation from the Administrator for a few moments.'));
            return back();
        } catch (Exception $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        } catch (Throwable $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        }
    }

    public function cancel_reservation(Reservation $reservation)
    {
        try {
            $reservation->update(['status' => ReservationType::Canceled]);

            Alert::success(__('Successfully!'), __('The :feature was successfully updated.', ['feature' => __('Reservation')]));
            return back();
        } catch (Exception $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        } catch (Throwable $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        }
    }

    public function update_account(AccountRequest $request)
    {
        try {
            $user = User::find(Auth::id());
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            Alert::success(__('Successfully!'), __('The :feature was successfully updated.', ['feature' => __('Account')]));
            return back();
        } catch (Exception $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        } catch (Throwable $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        }
    }
    public function update_password(PasswordRequest $request)
    {
        try {
            $user = User::find(Auth::id());
            $user->password = bcrypt($request->password);
            $user->save();

            Alert::success(__('Successfully!'), __('The :feature was successfully updated.', ['feature' => __('Account')]));
            return back();
        } catch (Exception $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        } catch (Throwable $e) {
            Alert::warning(__('Something went wrong!'), $e->getMessage());
            return back();
        }
    }
}

<?php

namespace App\Http\Livewire\Frontend\Account\Reservation;

use Exception;
use Throwable;
use App\Enums\MailType;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;
use App\Enums\ReservationType;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendReservationNotificationJob;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['do_cancel_item'];
    public $selection_id;

    public function render()
    {
        $reservations = Reservation::where('user_id', Auth::id())
            ->with('details', 'payment')
            ->latest()
            ->paginate(5);

        return view('livewire.frontend.account.reservation.index', compact('reservations'));
    }

    public function cancel_item($id)
    {
        $this->selection_id = $id;
        $this->alert(
            'warning',
            __('Confirmation!'),
            [
                'text' => __('Are you sure you want to cancel the :feature?', ['feature' => __('Reservation')]),
                'timer' => 0,
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => __('Yes, do it!'),
                'showCancelButton' => true,
                'cancelButtonText' => __('No, cancel!'),
                'onConfirmed' => 'do_cancel_item',
                'allowOutsideClick' => false,
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
            ]
        );
    }

    public function do_cancel_item()
    {
        try {
            $reservation = Reservation::findOrFail($this->selection_id);

            $reservation->update(['status' => ReservationType::Canceled]);
            dispatch(new SendReservationNotificationJob($reservation, $reservation->user->email, MailType::CancelReservation));

            $this->selection_id = null;
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully updated.', ['feature' => __('Reservation')])]
            );
        } catch (Exception $e) {
            $this->alert(
                'warning',
                __('Something went wrong!'),
                ['text' => $e->getMessage()]
            );
        } catch (Throwable $e) {
            $this->alert(
                'warning',
                __('Something went wrong!'),
                ['text' => $e->getMessage()]
            );
        }
    }
}

<?php

namespace App\Http\Livewire\Backend\Reservation;

use App\Enums\PaymentType;
use App\Enums\ReservationType;
use App\Models\Payment;
use Exception;
use Throwable;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;

class Index extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['do_delete_item', 'do_confirmation_item', 'do_payment_item', 'do_reject_item'];
    public $show = 10, $selection_id = '';

    public $search = '';

    #[Url]
    public $filter = ReservationType::WaitingForPayment;

    public function render()
    {
        $reservations = Reservation::latest()
            ->where(function ($q) {
                $q->where('orderer_name', 'like', '%' . $this->search . '%')
                    ->orWhere('id', 'like', '%' . $this->search);
            });

        if ($this->filter == ReservationType::WaitingForPayment)
            $reservations = $reservations->where('status', ReservationType::WaitingForPayment);
        elseif ($this->filter == ReservationType::ReadyForAction)
            $reservations = $reservations->where('status', ReservationType::ReadyForAction);
        elseif ($this->filter == ReservationType::Canceled)
            $reservations = $reservations->where('status', ReservationType::Canceled);
        elseif ($this->filter == ReservationType::Completed)
            $reservations = $reservations->where('status', ReservationType::Completed);

        $reservations = $reservations->paginate($this->show);

        $this->dispatch('glightboxReset');
        return view('livewire.backend.reservation.index', compact('reservations'));
    }

    public function delete_item($id)
    {
        $this->selection_id = $id;
        $this->alert(
            'warning',
            __('Confirmation!'),
            [
                'text' => __('Are you sure you want to delete the :feature?', ['feature' => __('Reservation')]),
                'timer' => 0,
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => __('Yes, delete it!'),
                'showCancelButton' => true,
                'cancelButtonText' => __('No, cancel!'),
                'onConfirmed' => 'do_delete_item',
                'allowOutsideClick' => false,
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
            ]
        );
    }

    public function do_delete_item()
    {
        DB::beginTransaction();
        try {
            $reservation = Reservation::findOrFail($this->selection_id);
            if ($reservation->payment) {
                Storage::delete('public/' . $reservation->payment->proof_of_payment);
                $reservation->payment->delete();
            }
            $reservation->delete();

            $this->selection_id = null;
            DB::commit();
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully deleted.', ['feature' => __('Reservation')])]
            );
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert(
                'warning',
                __('Something went wrong!'),
                ['text' => $e->getMessage()]
            );
        } catch (Throwable $e) {
            DB::rollBack();
            $this->alert(
                'warning',
                __('Something went wrong!'),
                ['text' => $e->getMessage()]
            );
        }
    }

    public function confirmation_item($id)
    {
        $this->selection_id = $id;
        $this->alert(
            'warning',
            __('Confirmation!'),
            [
                'text' => __('Are you sure you want to complete the :feature?', ['feature' => __('Reservation')]),
                'timer' => 0,
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => __('Yes, do it!'),
                'showCancelButton' => true,
                'cancelButtonText' => __('No, cancel!'),
                'onConfirmed' => 'do_confirmation_item',
                'allowOutsideClick' => false,
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
            ]
        );
    }

    public function do_confirmation_item()
    {
        try {
            $reservation = Reservation::findOrFail($this->selection_id);

            if ($reservation?->payment?->status != 'paid_off')
                return  $this->alert(
                    'warning',
                    __('Attention!'),
                    ['text' => __('Please confirm payment first.')]
                );

            $reservation->update(['status' => ReservationType::Completed]);

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
            $reservation->payment->update(['status' => PaymentType::WaitingForConfirmation]);

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

    public function payment_item($id)
    {
        $this->selection_id = $id;
        $this->alert(
            'warning',
            __('Confirmation!'),
            [
                'text' => __('Are you sure you want to confirmation the :feature?', ['feature' => __('Payment')]),
                'timer' => 0,
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'confirmButtonText' => __('Yes, do it!'),
                'showCancelButton' => true,
                'cancelButtonText' => __('No, cancel!'),
                'onConfirmed' => 'do_payment_item',
                'allowOutsideClick' => false,
                'confirmButtonColor' => '#3085d6',
                'cancelButtonColor' => '#d33',
            ]
        );
    }

    public function do_payment_item()
    {
        try {
            $reservation = Reservation::findOrFail($this->selection_id);
            $reservation->update(['status' => ReservationType::ReadyForAction]);
            if ($reservation->payment)
                $reservation->payment->update(['status' => PaymentType::PaidOff]);
            else
                Payment::create([
                    'reservation_id' => $reservation->id,
                    'payment_vendor_id' => 1,
                    'status' => PaymentType::PaidOff
                ]);

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

    public function set_reset_page()
    {
        $this->resetPage();
    }
}

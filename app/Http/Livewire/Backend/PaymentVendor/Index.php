<?php

namespace App\Http\Livewire\Backend\PaymentVendor;

use Exception;
use Throwable;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\PaymentVendor;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh_payment_vendor_table' => '$refresh', 'do_delete_item'];
    public $show = 10, $selection_id = '';

    public $search = '';

    public function render()
    {
        $payment_vendors = PaymentVendor::where('name', 'like', "%$this->search%")
            ->paginate($this->show);
        return view('livewire.backend.payment-vendor.index', compact('payment_vendors'));
    }

    public function set_reset_page()
    {
        $this->resetPage();
    }

    public function delete_item($id)
    {
        $this->selection_id = $id;
        $this->alert(
            'warning',
            __('Confirmation!'),
            [
                'text' => __('Are you sure you want to delete the :feature?', ['feature' => __('Payment Vendor')]),
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
        try {
            $payment_vendor = PaymentVendor::findOrFail($this->selection_id);

            if ($payment_vendor->payments->count() > 0)
                return  $this->alert(
                    'warning',
                    __('Attention!'),
                    ['text' => __('The :feature cannot be deleted once it has been used.', ['feature' => __('Payment Vendor')])]
                );

            Storage::delete('public/' . $payment_vendor->image);
            $payment_vendor->delete();
            $this->selection_id = null;
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully deleted.', ['feature' => __('Payment Vendor')])]
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

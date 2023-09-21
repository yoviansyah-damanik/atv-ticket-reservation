<?php

namespace App\Http\Livewire\Backend\PaymentVendor;

use Exception;
use Throwable;
use Livewire\Component;
use App\Models\PaymentVendor;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class EditModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_edit_form'];
    public $payment_vendor_id, $image, $name, $account_number, $description;

    public function render()
    {
        return view('livewire.backend.payment-vendor.edit-modal');
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|max:200',
            'account_number' => 'required|string|max:200',
            'description' => 'nullable|string|max:200'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'image' => __('Image'),
            'name' => __('Payment Vendor Name'),
            'account_number' => __('Register Number'),
            'description' => __('Description'),
        ];
    }

    public function refresh_edit_form($id)
    {
        $this->reset();
        $this->payment_vendor_id = $id;
        $payment_vendor = PaymentVendor::findOrFail($id);
        $this->name = $payment_vendor->name;
        $this->account_number = $payment_vendor->account_number;
        $this->description = $payment_vendor->description;
    }

    public function update_payment_vendor(): void
    {
        $this->validate();

        try {
            $payment_vendor = PaymentVendor::find($this->payment_vendor_id);
            $payment_vendor->name = $this->name;
            $payment_vendor->account_number = $this->account_number;
            if ($this->image) {
                Storage::delete('public/' . $payment_vendor->image);
                $filename = $this->image->store('payment-vendor-images', 'public');
                $payment_vendor->image = $filename;
            }
            $payment_vendor->description = $this->description != '' ? $this->description : null;
            $payment_vendor->save();

            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully updated.', ['feature' => __('Payment Vendor')])]
            );
            $this->dispatch('refresh_payment_vendor_table');
            $this->dispatch('modal-close');
        } catch (Exception $e) {
            $this->alert(
                'warning',
                __('Attention!'),
                ['text' => $e->getMessage()]
            );
        } catch (Throwable $e) {
            $this->alert(
                'warning',
                __('Attention!'),
                ['text' => $e->getMessage()]
            );
        }
    }
}

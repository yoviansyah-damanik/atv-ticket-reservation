<?php

namespace App\Http\Livewire\Backend\PaymentVendor;

use App\Models\PaymentVendor;
use Exception;
use Throwable;
use Livewire\Component;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_create_form'];
    public $image, $name, $account_number, $description;

    public function refresh_create_form()
    {
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.backend.payment-vendor.create-modal');
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|min:3|max:200',
            'account_number' => 'required|string|min:5|max:200',
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

    public function store(): void
    {
        $this->validate();

        try {
            $new_payment_vendor = new PaymentVendor();
            $new_payment_vendor->name = $this->name;
            $new_payment_vendor->account_number = $this->account_number;
            if ($this->image) {
                $filename = $this->image->store('package-images', 'public');
                $new_payment_vendor->image = $filename;
            }
            $new_payment_vendor->description = $this->description != '' ? $this->description : null;
            $new_payment_vendor->save();

            $this->reset();
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully created.', ['feature' => __('Payment Vendor')])]
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

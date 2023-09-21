<?php

namespace App\Http\Livewire\Backend\Package;

use Exception;
use Throwable;
use App\Models\Package;
use Livewire\Component;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_create_form'];
    public $title, $image, $price, $description;

    public function refresh_create_form()
    {
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.backend.package.create-modal');
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:1024',
            'title' => 'required|string|max:200',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:200'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'image' => __('Image'),
            'title' => __('Package Title'),
            'price' => __('Price'),
            'description' => __('Description'),
        ];
    }

    public function store(): void
    {
        $this->validate();

        try {
            $new_package = new Package();
            $new_package->title = $this->title;
            $new_package->price = $this->price;
            $new_package->description = $this->description != '' ? $this->description : null;
            if ($this->image) {
                $filename = $this->image->store('package-images', 'public');
                $new_package->image = $filename;
            }
            $new_package->save();

            $this->reset();
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully created.', ['feature' => __('Package')])]
            );
            $this->dispatch('refresh_package_table');
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

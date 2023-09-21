<?php

namespace App\Http\Livewire\Backend\Package;

use Exception;
use Throwable;
use App\Models\Package;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class EditModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_edit_form'];
    public $package_id, $image, $title, $price, $description;

    public function render()
    {
        return view('livewire.backend.package.edit-modal');
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

    public function refresh_edit_form($id)
    {
        $this->reset();
        $this->package_id = $id;
        $package = Package::findOrFail($id);
        $this->title = $package->title;
        $this->price = $package->price;
        $this->description = $package->description;
    }

    public function update_package(): void
    {
        $this->validate();

        try {
            $package = Package::find($this->package_id);
            $package->title = $this->title;
            $package->price = $this->price;
            $package->description = $this->description != '' ? $this->description : null;
            if ($this->image) {
                Storage::delete('public/' . $package->image);
                $filename = $this->image->store('package-images', 'public');
                $package->image = $filename;
            }
            $package->save();

            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully updated.', ['feature' => __('Package')])]
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

<?php

namespace App\Http\Livewire\Backend\Unit;

use Exception;
use Throwable;
use App\Models\Unit;
use Livewire\Component;
use Illuminate\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class CreateModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_create_form'];
    public $image, $name, $register_number, $description;

    public function refresh_create_form()
    {
        $this->reset();
    }

    public function render(): View
    {
        return view('livewire.backend.unit.create-modal');
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|max:200',
            'register_number' => 'required|string|max:200',
            'description' => 'nullable|string|max:200'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'image' => __('Image'),
            'name' => __('Unit Name'),
            'register_number' => __('Register Number'),
            'description' => __('Description'),
        ];
    }

    public function store(): void
    {
        $this->validate();

        try {
            $new_unit = new Unit();
            $new_unit->name = $this->name;
            $new_unit->register_number = $this->register_number;
            if ($this->image) {
                $filename = $this->image->store('unit-images', 'public');
                $new_unit->image = $filename;
            }
            $new_unit->description = $this->description != '' ? $this->description : null;
            $new_unit->save();

            $this->reset();
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully created.', ['feature' => __('Unit')])]
            );
            $this->dispatch('refresh_unit_table');
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

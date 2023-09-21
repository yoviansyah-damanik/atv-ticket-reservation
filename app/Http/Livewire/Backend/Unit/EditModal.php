<?php

namespace App\Http\Livewire\Backend\Unit;

use Exception;
use Throwable;
use App\Models\Unit;
use App\Enums\UnitType;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EditModal extends Component
{
    use LivewireAlert, WithFileUploads;

    protected $listeners = ['refresh_edit_form'];
    public $unit_id, $image, $name, $register_number, $description, $status;

    public function render()
    {
        return view('livewire.backend.unit.edit-modal');
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:1024',
            'name' => 'required|string|max:200',
            'register_number' => 'required|string|max:200',
            'description' => 'nullable|string|max:200',
            'status' => ['required', Rule::in(UnitType::getValues())]
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'image' => __('Image'),
            'name' => __('Unit Name'),
            'register_number' => __('Register Number'),
            'description' => __('Description'),
            'status' => __('Status')
        ];
    }

    public function refresh_edit_form($id)
    {
        $this->reset();
        $this->unit_id = $id;
        $unit = Unit::findOrFail($id);
        $this->name = $unit->name;
        $this->register_number = $unit->register_number;
        $this->description = $unit->description;
        $this->status = $unit->status;
    }

    public function update_unit(): void
    {
        $this->validate();

        try {
            $unit = Unit::find($this->unit_id);
            $unit->name = $this->name;
            $unit->register_number = $this->register_number;
            if ($this->image) {
                Storage::delete('public/' . $unit->image);
                $filename = $this->image->store('unit-images', 'public');
                $unit->image = $filename;
            }
            $unit->description = $this->description != '' ? $this->description : null;
            $unit->status = $this->status;
            $unit->save();

            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully updated.', ['feature' => __('Unit')])]
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

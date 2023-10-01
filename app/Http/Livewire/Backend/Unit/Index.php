<?php

namespace App\Http\Livewire\Backend\Unit;

use Exception;
use Throwable;
use App\Models\Unit;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh_unit_table' => '$refresh', 'do_delete_item'];
    public $show = 10, $selection_id = '';

    public $search = '';

    public function render()
    {
        $units = Unit::where('name', 'like', "%$this->search%")
            ->paginate($this->show);
        return view('livewire.backend.unit.index', compact('units'));
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
                'text' => __('Are you sure you want to delete the :feature?', ['feature' => __('Unit')]),
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
            $unit = Unit::findOrFail($this->selection_id);
            if ($unit->unit_usages->count() > 0)
                return  $this->alert(
                    'warning',
                    __('Attention!'),
                    ['text' => __('The :feature cannot be deleted once it has been used.', ['feature' => __('Unit')])]
                );

            Storage::delete('public/' . $unit->image);
            $unit->delete();
            $this->selection_id = null;
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully deleted.', ['feature' => __('Unit')])]
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

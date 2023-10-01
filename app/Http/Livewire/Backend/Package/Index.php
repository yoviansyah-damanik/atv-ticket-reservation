<?php

namespace App\Http\Livewire\Backend\Package;

use Exception;
use Throwable;
use App\Models\Package;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Index extends Component
{
    use WithPagination, LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['refresh_package_table' => '$refresh', 'do_delete_item'];
    public $show = 10, $selection_id = '';

    public $search = '';

    public function render()
    {
        $packages = Package::where('title', 'like', "%$this->search%")
            ->paginate($this->show);
        return view('livewire.backend.package.index', compact('packages'));
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
                'text' => __('Are you sure you want to delete the :feature?', ['feature' => __('Package')]),
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
            $package = Package::findOrFail($this->selection_id);
            if ($package->reservations->count() > 0)
                return  $this->alert(
                    'warning',
                    __('Attention!'),
                    ['text' => __('The :feature cannot be deleted once it has been used.', ['feature' => __('Package')])]
                );

            Storage::delete('public/' . $package->image);
            $package->delete();
            $this->selection_id = null;
            $this->alert(
                'success',
                __('Successfully!'),
                ['text' => __('The :feature was successfully deleted.', ['feature' => __('Package')])]
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

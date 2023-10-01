<?php

namespace App\Http\Livewire\Backend\Report\Revenue;

use Exception;
use Throwable;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Filter extends Component
{
    use LivewireAlert;

    public $month;
    public $year;

    public function mount()
    {
        $this->year = Carbon::now()->format('Y');
    }

    public function render()
    {
        return view('livewire.backend.report.revenue.filter');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function rules()
    {
        return [
            'year' => 'required|numeric|min:2023'
        ];
    }

    public function validationAttributes()
    {
        return [
            'year' => __('Year')
        ];
    }

    public function preview()
    {
        $this->validate();
        try {
            $this->dispatch('set_preview', $this->year);
        } catch (Exception $e) {
            $this->alert('warning', __('Something went wrong!', ['text' => $e->getMessage()]));
        } catch (Throwable $e) {
            $this->alert('warning', __('Something went wrong!', ['text' => $e->getMessage()]));
        }
    }
}

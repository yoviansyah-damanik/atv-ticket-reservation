<?php

namespace App\Http\Livewire\Backend\Report\Unit;

use Exception;
use Throwable;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Filter extends Component
{
    use LivewireAlert;

    public $month;
    public $year;

    public function mount()
    {
        $this->month = Carbon::now()->format('m');
        $this->year = Carbon::now()->format('Y');
    }

    public function render()
    {
        return view('livewire.backend.report.unit.filter');
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function rules()
    {
        return [
            'month' => ['required', Rule::in([...range(1, 12), 'all'])],
            'year' => 'required|numeric|min:2023'
        ];
    }

    public function validationAttributes()
    {
        return [
            'month' => __('Month'),
            'year' => __('Year')
        ];
    }

    public function preview()
    {
        $this->validate();
        try {
            $this->dispatch('set_preview', $this->month, $this->year);
        } catch (Exception $e) {
            $this->alert('warning', __('Something went wrong!', ['text' => $e->getMessage()]));
        } catch (Throwable $e) {
            $this->alert('warning', __('Something went wrong!', ['text' => $e->getMessage()]));
        }
    }
}

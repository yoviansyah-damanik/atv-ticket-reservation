<?php

namespace App\Http\Livewire\Backend\Schedule;

use App\Enums\ReservationType;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\Reservation;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $show = 10, $selection_id = '';

    public $search = '';
    public $filter = 1;

    public function render()
    {
        $reservations = Reservation::whereIn('status', [ReservationType::ReadyForAction, ReservationType::Completed])
            ->with('payment', 'details')
            ->where('orderer_name', 'like', "%$this->search%")
            ->orderBy('date', 'asc');

        if ($this->filter == 1)
            $reservations = $reservations->where('date', Carbon::now()->format('Y-m-d'));
        elseif ($this->filter == 2)
            $reservations = $reservations->where('date', '>=', Carbon::now()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->addDays(7)->format('Y-m-d'));
        elseif ($this->filter == 3)
            $reservations = $reservations->where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->addDays(14)->format('Y-m-d'));
        elseif ($this->filter == 4)
            $reservations = $reservations->where('date', '>=', Carbon::now()->startOfMonth()->format('Y-m-d'))
                ->where('date', '<=', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $reservations = $reservations->paginate($this->show);

        return view('livewire.backend.schedule.index', compact('reservations'));
    }
}

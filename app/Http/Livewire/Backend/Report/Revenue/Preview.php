<?php

namespace App\Http\Livewire\Backend\Report\Revenue;

use Carbon\Carbon;
use Livewire\Component;
use App\Models\Reservation;
use App\Helpers\ReportHelper;
use App\Enums\ReservationType;

class Preview extends Component
{
    protected $listeners = ['set_preview'];

    public $year;
    public $data;
    public $period;

    public function render()
    {
        if (!empty($this->year)) {
            $date_period = range(1, 12);
            $this->period = $date_period;

            $reservations = Reservation::completedStatus()
                ->get();

            $this->data = collect(range(1, 12))->map(function ($q) use ($reservations) {
                $start_of_month = Carbon::createFromFormat('m-Y', $q . '-' . $this->year)->startOfMonth();
                $end_of_month = Carbon::createFromFormat('m-Y', $q . '-' . $this->year)->endOfMonth();
                return [
                    'month_id' => $q,
                    'month_name' => Carbon::createFromFormat('m', $q)->translatedFormat('F'),
                    'revenue' => $reservations
                        ->whereIn('status', [ReservationType::ReadyForAction, ReservationType::Completed])
                        ->filter(function ($r) use ($start_of_month, $end_of_month) {
                            if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                                return $r;
                        })->sum(function ($r) {
                            return $r->details->sum('total_payment');
                        })
                ];
            });
        }

        return view('livewire.backend.report.revenue.preview');
    }

    public function set_preview($year)
    {
        $this->year = $year;
    }

    public function refresh()
    {
        $this->reset();
    }

    public function print()
    {

        $filename = Carbon::now()->timestamp . ' - ' . __('Revenue Report for :year', ['year' => $this->year]) . '.pdf';
        return response()->streamDownload(
            function () {
                print(ReportHelper::revenue_report_print($this->data, $this->year));
            },
            $filename
        );
    }
}

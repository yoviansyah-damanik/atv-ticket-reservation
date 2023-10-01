<?php

namespace App\Http\Livewire\Backend\Report\Unit;

use Carbon\Carbon;
use App\Models\Unit;
use Livewire\Component;
use Carbon\CarbonPeriod;
use App\Models\Reservation;
use App\Helpers\ReportHelper;
use App\Enums\ReservationType;

class Preview extends Component
{
    protected $listeners = ['set_preview'];

    public $month;
    public $year;
    public $data;
    public $period;

    public function render()
    {
        if ($this->month && $this->year) {
            $reservations = Reservation::where('status', ReservationType::Completed)
                ->with('unit_usages')
                ->get();
            $units = Unit::get();

            if ($this->month != 'all') {
                $start_period = Carbon::createFromFormat('mY', $this->month . $this->year)->startOfMonth()->format('Y-m-d');
                $end_period = Carbon::createFromFormat('mY', $this->month . $this->year)->endOfMonth()->format('Y-m-d');
                $period = CarbonPeriod::since($start_period)->until($end_period);

                $date_period = [];
                foreach ($period as $date) {
                    $date_period[] = $date->format('Y-m-d');
                }

                $this->period = $date_period;
                $this->data = $units->map(function ($q) use ($reservations, $date_period) {
                    return [
                        'unit_id' => $q->id,
                        'unit_name' => $q->name,
                        'unit_usage' => collect($date_period)->map(function ($r) use ($reservations, $q) {
                            return [
                                'date' => $r,
                                'count' => $reservations->where('date', $r)->sum(function ($s) use ($q) {
                                    return $s->unit_usages()->where('unit_id', $q->id)->count();
                                })
                            ];
                        })
                    ];
                });
            } else {
                $date_period = range(1, 12);
                $this->period = $date_period;
                $this->data = $units->map(function ($q) use ($reservations, $date_period) {
                    return [
                        'unit_id' => $q->id,
                        'unit_name' => $q->name,
                        'unit_usage' => collect($date_period)->map(function ($r) use ($reservations, $q) {
                            $start_of_month = Carbon::createFromFormat('m', $r)->startOfMonth();
                            $end_of_month = Carbon::createFromFormat('m', $r)->endOfMonth();
                            return [
                                'month_id' => $r,
                                'month_name' => Carbon::createFromFormat('m', $r)->translatedFormat('F'),
                                'count' => $reservations
                                    ->filter(function ($r) use ($start_of_month, $end_of_month) {
                                        if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                                            return $r;
                                    })
                                    ->sum(function ($s) use ($q) {
                                        return $s->unit_usages()
                                            ->where('unit_id', $q->id)
                                            ->count();
                                    })
                            ];
                        })
                    ];
                });
            }
        }

        return view('livewire.backend.report.unit.preview');
    }

    public function set_preview($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function refresh()
    {
        $this->reset();
    }

    public function print()
    {
        if ($this->month != 'all') {
            $filename = Carbon::now()->timestamp . ' - ' . __('Unit Usage Report for :month :year', ['month' => Carbon::createFromFormat('m', $this->month)->translatedFormat('F'), 'year' => $this->year]) . '.pdf';
            return response()->streamDownload(
                function () {
                    print(ReportHelper::unit_report_print($this->data, $this->month, $this->year, $this->period));
                },
                $filename
            );
        } else {
            $filename = Carbon::now()->timestamp . ' - ' . __('Unit Usage Report for :year', ['year' => $this->year]) . '.pdf';
            return response()->streamDownload(
                function () {
                    print(ReportHelper::unit_all_report_print($this->data, $this->year, $this->period));
                },
                $filename
            );
        }
    }
}

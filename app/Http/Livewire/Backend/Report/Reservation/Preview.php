<?php

namespace App\Http\Livewire\Backend\Report\Reservation;

use Carbon\Carbon;
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
    public $period;
    public $data;

    public function render()
    {
        if ($this->month && $this->year) {
            $reservations = Reservation::get();

            if ($this->month != 'all') {
                $start_period = Carbon::createFromFormat('m-Y', $this->month . '-' . $this->year)->startOfMonth()->format('Y-m-d');
                $end_period = Carbon::createFromFormat('m-Y', $this->month . '-' . $this->year)->endOfMonth()->format('Y-m-d');
                $period = CarbonPeriod::since($start_period)->until($end_period);

                $date_period = [];
                foreach ($period as $date) {
                    $date_period[] = $date->format('Y-m-d');
                }

                $this->period = $date_period;
                $this->data = collect($date_period)->map(function ($q) use ($reservations) {
                    return [
                        'date' => $q,
                        'reservations' => [
                            ReservationType::WaitingForPayment => $reservations->where('date', $q)->where('status', ReservationType::WaitingForPayment)->count(),
                            ReservationType::ReadyForAction => $reservations->where('date', $q)->where('status', ReservationType::ReadyForAction)->count(),
                            ReservationType::Completed => $reservations->where('date', $q)->where('status', ReservationType::Completed)->count(),
                            ReservationType::Canceled => $reservations->where('date', $q)->where('status', ReservationType::Canceled)->count(),
                        ]
                    ];
                });
            } else {
                $this->data = collect(range(1, 12))->map(function ($q) use ($reservations) {
                    $start_of_month = Carbon::createFromFormat('m-Y', $q . '-' . $this->year)->startOfMonth();
                    $end_of_month = Carbon::createFromFormat('m-Y', $q . '-' . $this->year)->endOfMonth();
                    return [
                        'month_id' => $q,
                        'month_name' => Carbon::createFromFormat('m', $q)->translatedFormat('F'),
                        'reservations' => [
                            ReservationType::WaitingForPayment => $reservations
                                ->where('status', ReservationType::WaitingForPayment)
                                ->filter(function ($r) use ($start_of_month, $end_of_month) {
                                    if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                                        return $r;
                                })
                                ->count(),
                            ReservationType::ReadyForAction => $reservations
                                ->where('status', ReservationType::ReadyForAction)
                                ->filter(function ($r) use ($start_of_month, $end_of_month) {
                                    if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                                        return $r;
                                })
                                ->count(),
                            ReservationType::Completed => $reservations
                                ->where('status', ReservationType::Completed)
                                ->filter(function ($r) use ($start_of_month, $end_of_month) {
                                    if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                                        return $r;
                                })
                                ->count(),
                            ReservationType::Canceled => $reservations
                                ->where('status', ReservationType::Canceled)
                                ->filter(function ($r) use ($start_of_month, $end_of_month) {
                                    if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                                        return $r;
                                })
                                ->count(),
                        ]
                    ];
                });
            }
        }

        return view('livewire.backend.report.reservation.preview');
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
            $filename = Carbon::now()->timestamp . ' - ' . __('Reservation Report for :month :year', ['month' => Carbon::createFromFormat('m', $this->month)->translatedFormat('F'), 'year' => $this->year]) . '.pdf';
            return response()->streamDownload(
                function () {
                    print(ReportHelper::reservation_report_print($this->data, $this->month, $this->year));
                },
                $filename
            );
        } else {
            $filename = Carbon::now()->timestamp . ' - ' . __('Reservation Report for :year', ['year' => $this->year]) . '.pdf';
            return response()->streamDownload(
                function () {
                    print(ReportHelper::reservation_all_report_print($this->data, $this->year));
                },
                $filename
            );
        }
    }
}

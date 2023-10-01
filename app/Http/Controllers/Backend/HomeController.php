<?php

namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Unit;
use Illuminate\View\View;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Enums\ReservationType;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public $year;

    public function __construct()
    {
        $this->year = date('Y');
    }

    public function index(): View
    {
        $reservations = Reservation::with('details', 'unit_usages', 'payment')
            ->get();
        $units = Unit::get();

        $completed_reservation = $reservations->whereIn('status', [ReservationType::ReadyForAction, ReservationType::Completed]);

        $waiting_for_payment_count = $reservations->where('status', ReservationType::WaitingForPayment)
            ->count();
        $ready_for_action_count = $reservations->where('status', ReservationType::ReadyForAction)
            ->count();
        $completed_count = $reservations->where('status', ReservationType::Completed)
            ->count();
        $canceled_count = $reservations->where('status', ReservationType::Canceled)
            ->count();

        $last_reservation_completed = $reservations->whereIn('status', [ReservationType::ReadyForAction, ReservationType::Completed])
            ->sortByDesc('updated_at')
            ->take(10);

        $percentage_of_reservation_complete = ($completed_count + $ready_for_action_count) / $reservations->count() * 100;

        $revenue = collect(range(1, 12))->map(function ($q) use ($completed_reservation) {
            $start_of_month = Carbon::createFromFormat('m-Y', $q . '-' . $this->year)->startOfMonth();
            $end_of_month = Carbon::createFromFormat('m-Y', $q . '-' . $this->year)->endOfMonth();

            return [
                'month_id' => $q,
                'month_name' => Carbon::createFromFormat('m', $q)->translatedFormat('F'),
                'revenue' => $completed_reservation
                    ->filter(function ($r) use ($start_of_month, $end_of_month) {
                        if (Carbon::parse($r->date)->between($start_of_month, $end_of_month))
                            return $r;
                    })->sum(function ($r) {
                        return $r->details->sum('total_payment');
                    })
            ];
        });

        if (date('m') - 1 <= 0) $revenue_last_month = 0;
        else $revenue_last_month = $revenue->where('month_id', date('m') - 1)->first()['revenue'];

        $revenue_this_month = $revenue->where('month_id', date('m'))->first()['revenue'];
        $is_revenue_increase = $revenue_this_month > $revenue_last_month ? true : false;
        $revenue_total = $revenue->sum('revenue');

        $unit_usages = $units->map(function ($q) use ($reservations) {
            return [
                'unit_id' => $q->id,
                'unit_name' => $q->name,
                'unit_usage' =>  $reservations->sum(function ($s) use ($q) {
                    return $s->unit_usages()->where('unit_id', $q->id)->count();
                }),
                'percentage' => $reservations->sum(function ($s) use ($q) {
                    return $s->unit_usages()->where('unit_id', $q->id)->count();
                }) /  $reservations->sum(function ($s) use ($q) {
                    return $s->unit_usages->count();
                }) * 100
            ];
        });

        return view('backend.pages.home.index', [
            'waiting_for_payment_count' => $waiting_for_payment_count,
            'ready_for_action_count' => $ready_for_action_count,
            'completed_count' => $completed_count,
            'canceled_count' => $canceled_count,
            'last_reservation_completed' => $last_reservation_completed,
            'percentage_of_reservation_complete' => $percentage_of_reservation_complete,
            'revenue_this_month' => $revenue_this_month,
            'revenue_last_month' => $revenue_last_month,
            'is_revenue_increase' => $is_revenue_increase,
            'revenue_total' => $revenue_total,
            'unit_usages' => $unit_usages
        ]);
    }
}

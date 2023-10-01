<?php

namespace App\Http\Livewire\Frontend\Reservation;

use Exception;
use Throwable;
use Carbon\Carbon;
use App\Models\Package;
use Livewire\Component;
use App\Models\Reservation;
use Illuminate\Validation\Rule;
use App\Models\ReservationDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use RealRashid\SweetAlert\Facades\Alert;

class Book extends Component
{
    use LivewireAlert;
    public $times = [];
    public $selected_package = [];
    public $orderer_name = '';
    public $date, $time, $packages;
    public $total_payment = 0;
    public $total_package = 0;
    public $package_amount = [];

    public function mount()
    {
        $this->times = ['10:00', '10:30', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30'];
        // $this->date = Carbon::now()->addDays(1)->format('d/m/Y');
        $this->time = $this->times[0];
        $this->orderer_name = Auth::user()->name;
        $this->packages = Package::get();
    }

    public function render()
    {
        $this->selected_package = collect($this->selected_package)
            ->filter(fn ($item, $key) => $item['status'] == true);

        $selected_keys = $this->selected_package
            ->keys();

        $selected_packages_show = collect($this->packages)
            ->whereIn('id', $selected_keys);

        $this->selected_package = $this->selected_package
            ->map(function ($item, $key) use ($selected_packages_show) {
                return [
                    'status' => $item['status'],
                    'amount' => $item['amount'] ?? 1,
                    'price' => $selected_packages_show->where('id', $key)->first()->price,
                ];
            });

        $this->total_package = $this->selected_package->sum('amount') ?? 0;
        $this->total_payment = $this->selected_package->sum(fn ($item) => $item['amount'] * $item['price']);

        return view('livewire.frontend.reservation.book', [
            'times' => $this->times,
            'packages' => $this->packages,
            'selected_packages_show' => $selected_packages_show
        ]);
    }

    public function rules(): array
    {
        return [
            'orderer_name' => 'required|string|min:8|max:200',
            'date' => 'required|string|date_format:d/m/Y|after_or_equal:' . date('Y-m-d'),
            'time' => [
                'required',
                Rule::in($this->times)
            ],
            'selected_package' => 'required|array',
            'selected_package.*.status' => 'required|boolean',
            'selected_package.*.price' => 'sometimes|required|numeric',
            'selected_package.*.amount' => 'sometimes|required|numeric|min:1'
        ];
    }

    public function validationAttributes(): array
    {
        return [
            'orderer_name' => __('Orderer Name'),
            'date' => __('Date'),
            'time' => __('Expectation Time'),
            'selected_package' => __('Selected Package'),
            'selected_package.*.amount' => __('Number of packages')
        ];
    }

    public function updated($attribute)
    {
        $this->validateOnly($attribute);
    }

    public function store_reservation()
    {
        $this->validate();
        DB::beginTransaction();
        try {
            $new_reservation = new Reservation();
            $new_reservation->user_id = Auth::id();
            $new_reservation->orderer_name = $this->orderer_name;
            $new_reservation->date = Carbon::createFromFormat('d/m/Y', $this->date)->format('Y-m-d');
            $new_reservation->time = $this->time;
            $new_reservation->save();

            foreach ($this->selected_package as $key => $item) {
                $new_detail_reservation = new ReservationDetail();
                $new_detail_reservation->reservation_id = $new_reservation->id;
                $new_detail_reservation->package_id = $key;
                $new_detail_reservation->amount = $item['amount'];
                $new_detail_reservation->price = $item['price'];
                $new_detail_reservation->save();
            }

            DB::commit();
            Alert::success(__('Successfully!'), __('Your reservation has been successfully made. Please confirm your payment if you use an electronic payment platform.'));
            return to_route('account.history.show', $new_reservation->id);
        } catch (Exception $e) {
            DB::rollBack();
            $this->alert('warning', __('Warning!'), ['text' => $e->getMessage()]);
        } catch (Throwable $e) {
            DB::rollBack();
            $this->alert('warning', __('Warning!'), ['text' => $e->getMessage()]);
        }
    }
}

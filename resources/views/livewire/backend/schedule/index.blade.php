<div>
    {{-- Page header  --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    {{-- Page pre-title  --}}
                    <h2 class="page-title">
                        {{ __('Schedule') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    {{-- Page body  --}}
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __(':data Data', ['data' => __('Schedule')]) }}</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    {{ __('Show') }}
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.lazy="show" size="3" wire:change='set_reset_page'>
                                    </div>
                                    {{ __('entries') }}
                                </div>
                                <div class="ms-auto text-muted">
                                    {{ __('Search:') }}
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" aria-label="Search"
                                            wire:model.live="search" wire:change='set_reset_page'>
                                    </div>
                                </div>
                            </div>
                            <div class="my-3">
                                <div class="btn-group w-100" role="group">
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-1" autocomplete="off" wire:model.live='filter' value=1>
                                    <label for="btn-radio-basic-1" type="button" class="btn">
                                        {{ __('Today') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-2" autocomplete="off" wire:model.live='filter' value=2>
                                    <label for="btn-radio-basic-2" type="button" class="btn">
                                        {{ __('Next 7 Days') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-3" autocomplete="off" wire:model.live='filter' value=3>
                                    <label for="btn-radio-basic-3" type="button" class="btn">
                                        {{ __('Next 14 Days') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-4" autocomplete="off" wire:model.live='filter' value=4>
                                    <label for="btn-radio-basic-4" type="button" class="btn">
                                        {{ __('This Month') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-5" autocomplete="off" wire:model.live='filter' value=5>
                                    <label for="btn-radio-basic-5" type="button" class="btn">
                                        {{ __('All') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Expectation Time') }}</th>
                                        <th>{{ __('Orderer Name') }}</th>
                                        <th>{{ __('Total Package') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reservations as $reservation)
                                        <tr>
                                            <td>
                                                {{ $reservations->perPage() * ($reservations->currentPage() - 1) + $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ Carbon::parse($reservation->date)->translatedFormat('d F Y') }}
                                            </td>
                                            <td>
                                                {{ Carbon::parse($reservation->time)->translatedFormat('H:i') }} WIB
                                            </td>
                                            <td>
                                                {{ $reservation->orderer_name }}
                                            </td>
                                            <td>
                                                {{ $reservation->details->sum('amount') }}
                                            </td>
                                            <td>
                                                @if ($reservation->status == 'waiting_for_payment')
                                                    <span class="status status-yellow">
                                                        {{ __('Waiting for Payment') }}
                                                    </span>
                                                @elseif($reservation->status == 'ready_for_action')
                                                    <span class="status status-blue">
                                                        {{ __('Ready for Action') }}
                                                    </span>
                                                @elseif($reservation->status == 'canceled')
                                                    <span class="status status-red">
                                                        {{ __('Reservation Canceled') }}
                                                    </span>
                                                @else
                                                    <span class="status status-green">
                                                        {{ __('Reservation Completed') }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('dashboard.reservation.show', $reservation->id) }}">
                                                    {{ __('Show') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan=7>
                                                {{ __('No data found.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-center align-items-center">
                            {{ $reservations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

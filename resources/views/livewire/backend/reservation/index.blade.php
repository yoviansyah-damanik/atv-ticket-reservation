<div>
    {{-- Page header  --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    {{-- Page pre-title  --}}
                    <h2 class="page-title">
                        {{ __('Reservation') }}
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
                            <h3 class="card-title">{{ __(':data Data', ['data' => __('Reservation')]) }}</h3>
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
                                        id="btn-radio-basic-1" autocomplete="off" wire:model.live='filter'
                                        value="{{ ReservationType::WaitingForPayment }}">
                                    <label for="btn-radio-basic-1" type="button" class="btn">
                                        {{ __('Waiting for Payment') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-2" autocomplete="off" wire:model.live='filter'
                                        value="{{ ReservationType::ReadyForAction }}">
                                    <label for="btn-radio-basic-2" type="button" class="btn">
                                        {{ __('Ready for Action') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-3" autocomplete="off" wire:model.live='filter'
                                        value="{{ ReservationType::Canceled }}">
                                    <label for="btn-radio-basic-3" type="button" class="btn">
                                        {{ __('Canceled') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-4" autocomplete="off" wire:model.live='filter'
                                        value="{{ ReservationType::Completed }}">
                                    <label for="btn-radio-basic-4" type="button" class="btn">
                                        {{ __('Completed') }}
                                    </label>
                                    <input type="radio" class="btn-check" name="btn-radio-basic"
                                        id="btn-radio-basic-5" autocomplete="off" wire:model.live='filter'
                                        value="all">
                                    <label for="btn-radio-basic-5" type="button" class="btn">
                                        {{ __('All') }}
                                    </label>
                                </div>
                            </div>
                            <div class="mt-4">
                                @forelse ($reservations as $reservation)
                                    <div class="card mb-3">
                                        <div class="card-header">
                                            <h3 class="card-title">#{{ $reservation->id }}</h3>
                                        </div>
                                        <div class="card-body">
                                            @if ($reservation?->payment?->status == 'paid_off')
                                                <div class="paid_off_icon"></div>
                                            @endif
                                            <div class="datagrid">
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Orderer Name') }}</div>
                                                    <div class="datagrid-content">{{ $reservation->orderer_name }}
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Reservation Date') }}</div>
                                                    <div class="datagrid-content">
                                                        {{ Carbon::parse($reservation->date)->translatedFormat('l, d M Y') }}
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Expectation Time') }}</div>
                                                    <div class="datagrid-content">
                                                        {{ Carbon::parse($reservation->time)->format('H:i') }} WIB
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Status') }}</div>
                                                    <div class="datagrid-content">
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
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('User') }}</div>
                                                    <div class="datagrid-content">
                                                        <div class="d-flex align-items-center">
                                                            <span class="avatar avatar-xs me-2 rounded"
                                                                style="background-image: url({{ asset('branding-assets/img/user-default.png') }})"></span>
                                                            {{ $reservation->user->name }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Order Time') }}</div>
                                                    <div class="datagrid-content">
                                                        {{ $reservation->created_at->translatedFormat('d F Y H:i') }}
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Total Package') }}</div>
                                                    <div class="datagrid-content">
                                                        {{ PriceHelper::idr($reservation->details->sum('amount')) }}
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Total Payment') }}</div>
                                                    <div class="datagrid-content">
                                                        {{ PriceHelper::idr($reservation->details->sum('total_payment'), 0, true) }}
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Payment Vendor') }}</div>
                                                    <div class="datagrid-content">
                                                        {{ $reservation?->payment?->payment_vendor?->name ?? '-' }}
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Proof of Payment') }}</div>
                                                    <div class="datagrid-content">
                                                        @if ($reservation?->payment?->proof_of_payment)
                                                            <a class="glightbox"
                                                                data-gallery="gallery-{{ $reservation->id }}"
                                                                href="{{ $reservation->payment->proof_path }}">
                                                                {{ __('Click Here') }}
                                                            </a>
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-title">{{ __('Confirm Payment') }}</div>
                                                    <div class="datagrid-content">
                                                        @if ($reservation->status == 'canceled')
                                                            -
                                                        @else
                                                            @if ($reservation?->payment?->status == 'paid_off')
                                                                <span class="status status-green">
                                                                    {{ __('Done') }}
                                                                </span>
                                                            @else
                                                                <button class="btn btn-sm btn-success"
                                                                    wire:click="payment_item('{{ $reservation->id }}')">
                                                                    {{ __('Click Here') }}
                                                                </button>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="datagrid-item">
                                                    <div class="datagrid-content">
                                                        <a href="{{ route('dashboard.reservation.show', $reservation->id) }}"
                                                            class="btn btn-primary">
                                                            {{ __('View Reservation') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="datagrid-item">
                                                    <div class="datagrid-title">
                                                        {{ __('Complete Reservation') }}
                                                    </div>
                                                    <div class="datagrid-content">
                                                        @if ($reservation->status == 'completed')
                                                            <span class="status status-green">
                                                                {{ __('Done') }}
                                                            </span>
                                                        @elseif(in_array($reservation->status, ['waiting_for_payment', 'ready_for_action']))
                                                            <button class="btn btn-sm btn-success"
                                                                wire:click="confirmation_item('{{ $reservation->id }}')">
                                                                {{ __('Confirmation') }}
                                                            </button>
                                                            <button class="btn btn-sm btn-danger"
                                                                wire:click="cancel_item('{{ $reservation->id }}')">
                                                                {{ __('Cancel') }}
                                                            </button>
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div> --}}

                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center">
                                        {{ __('No data found.') }}
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        <div class="mt-4 d-flex justify-content-center align-items-center">
                            {{ $reservations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

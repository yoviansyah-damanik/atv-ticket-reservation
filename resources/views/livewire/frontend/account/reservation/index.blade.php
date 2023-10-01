<div>
    @foreach ($reservations as $reservation)
        <div class="card mb-3">
            <div class="card-body">
                <div class="reservation-box">
                    @if ($reservation?->payment?->status == 'paid_off')
                        <div class="paid_off"></div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="number">
                                #{{ $reservation->id }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="status">
                                <span class="{{ $reservation->status }}">
                                    @if ($reservation->status == 'waiting_for_payment')
                                        {{ __('Waiting for Payment') }}
                                    @elseif($reservation->status == 'ready_for_action')
                                        {{ __('Ready for Action') }}
                                    @elseif($reservation->status == 'canceled')
                                        {{ __('Reservation Canceled') }}
                                    @else
                                        {{ __('Reservation Completed') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="mb-0">
                        <strong>{{ __('Orderer Name') }}:</strong> {{ $reservation->orderer_name }}
                    </p>
                    <p>
                        <strong>{{ __('Total Package') }}:</strong> {{ $reservation->details->sum('amount') }}
                    </p>

                    <p class="mb-0">
                        <strong>{{ __('Reservation Date') }}:</strong>
                        {{ Carbon::parse($reservation->date)->translatedFormat('d F Y') }}
                    </p>
                    <p>
                        <strong>{{ __('Expectation Time') }}:</strong>
                        {{ Carbon::parse($reservation->time)->format('H:i') }} WIB
                    </p>

                    <p class="mb-0 d-flex align-items-baseline">
                        <strong>{{ __('Total Payment') }}:</strong>
                        <span class="total_payment">
                            {{ PriceHelper::idr($reservation->details->sum('total_payment'), 0, true) }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fst-italic me-3">
                        {{ $reservation->created_at->translatedFormat('d F Y H:i:s') }}
                    </span>
                    <div class="text-end">
                        @if ($reservation->status == 'waiting_for_payment')
                            <button class="btn btn-sm btn-danger" wire:click='cancel_item("{{ $reservation->id }}")'>
                                {{ __('Cancel Reservation') }}
                            </button>
                        @endif

                        <a href="{{ route('account.history.show', $reservation->id) }}" class="btn btn-sm btn-primary">
                            {{ __('View Reservation') }}
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endforeach

    <div class="mt-4 text-center d-flex justify-content-center">
        {{ $reservations->links() }}
    </div>
</div>

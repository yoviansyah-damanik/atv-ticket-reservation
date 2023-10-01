@extends('backend.layouts.app')

@section('title', __('Reservation'))
@section('content')
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
                <a href="{{ route('dashboard.reservation') }}" class="btn btn-light mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-back" width="24"
                        height="24" viewBox="0 0 P24 24" stroke-width="2" stroke="currentColor" fill="none"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M9 11l-4 4l4 4m-4 -4h11a4 4 0 0 0 0 -8h-1"></path>
                    </svg>
                    {{ __('Back') }}
                </a>
                <div class="row row-cards">
                    <div class="col-lg-9">
                        <div class="card">
                            <div class="card-header row justify-content-between align-items-center">
                                <div class="col-md-6">
                                    <h3 class="mb-0">
                                        #{{ $reservation->id }}
                                    </h3>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-start text-lg-end">
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
                            </div>
                            <div class="card-body border-bottom py-3">
                                @if ($reservation?->payment?->status == 'paid_off')
                                    <div class="paid_off_icon" style="bottom:0; top:3rem;"></div>
                                @endif
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

                                {{-- <p>
                                    <strong>{{ __('Payment Status') }}:</strong>
                                    @if ($reservation?->payment?->status == 'paid_off')
                                        <span class="text-succcess">
                                            {{ __('Paid Off') }}
                                        </span>
                                    @else
                                        <span class="text-warning">
                                            {{ __('Waiting for Payment') }}
                                        </span>
                                    @endif
                                </p> --}}

                                <h3>{{ __('Package Details') }}</h3>
                                <table class="table">
                                    <thead>
                                        <th>#</th>
                                        <th>{{ __('Package Title') }}</th>
                                        <th>{{ __('Price') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Total') }}</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservation->details as $item)
                                            <tr>
                                                <td>
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    {{ $item->package->title }}
                                                </td>
                                                <td>
                                                    {{ PriceHelper::idr($item->price, 0, true) }}
                                                </td>
                                                <td>
                                                    {{ $item->amount }}
                                                </td>
                                                <td>
                                                    {{ PriceHelper::idr($item->total_payment, 0, true) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <p class="mb-0 d-flex align-items-baseline justify-content-end">
                                    <strong>{{ __('Total Payment') }}:</strong>
                                    <span class="display-6 text-danger ms-3 fw-bold">
                                        {{ PriceHelper::idr($reservation->details->sum('total_payment'), 0, true) }}
                                    </span>
                                </p>
                            </div>
                            <div class="card-footer">
                                <div class="datagrid">
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
                                                    <form
                                                        action="{{ route('dashboard.reservation.confirm-payment', $reservation->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('put')
                                                        <button id="confirm_payment" class="btn btn-success">
                                                            {{ __('Confirm Payment') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="datagrid-item">
                                        <div class="datagrid-title">
                                            {{ __('Complete Reservation') }}
                                        </div>
                                        <div class="datagrid-content">
                                            @if ($reservation->status == 'completed')
                                                <span class="status status-green">
                                                    {{ __('Done') }}
                                                </span>
                                            @elseif(in_array($reservation->status, ['waiting_for_payment', 'ready_for_action']))
                                                <form class="d-inline"
                                                    action="{{ route('dashboard.reservation.confirmation', $reservation->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button id="confirmation" class="btn btn-success">
                                                        {{ __('Confirmation') }}
                                                    </button>
                                                </form>
                                                <form class="d-inline"
                                                    action="{{ route('dashboard.reservation.cancel', $reservation->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('put')
                                                    <button id="cancel" class="btn btn-danger">
                                                        {{ __('Cancel') }}
                                                    </button>
                                                </form>
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="mb-0">
                                    {{ __('Unit Usage') }}
                                </h3>
                            </div>
                            <div class="card-body">
                                @if ($reservation?->payment?->status == 'paid_off')
                                    @if ($reservation?->unit_usages)
                                        <table class="table table-sm">
                                            <thead>
                                                <th>#</th>
                                                <th>{{ __('Unit Name') }}</th>
                                            </thead>
                                            <tbody>
                                                @forelse ($reservation->unit_usages as $unit)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $unit->unit->name }}</td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td class="text-center" colspan=2>
                                                            {{ __('No data found.') }}
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    @endif
                                    @if ($reservation->status != ReservationType::Completed)
                                        <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                            data-bs-target="#select-unit-modal">
                                            {{ __('Select Units') }}
                                        </button>
                                    @endif
                                @else
                                    {{ __('Please confirm payment first.') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if ($reservation->status != ReservationType::Completed)
        <div class="modal modal-blur fade" id="select-unit-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-scrollbar-measure" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ __('Select Units') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('dashboard.reservation.set-unit', $reservation->id) }}" method='post'>
                        <div class="modal-body">
                            @csrf
                            @method('put')
                            @foreach (range(1, $reservation->details->sum('amount')) as $item)
                                <div class="mb-3">
                                    <label for="unit-{{ $loop->iteration }}" class="form-label">
                                        {{ __('Select Unit') }} {{ $loop->iteration }}
                                    </label>
                                    <select class="form-select" name="selected_units[]" id="unit-{{ $loop->iteration }}"
                                        required>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selected_units.{{ $loop->iteration - 1 }}')
                                        <div class="mt-1 small text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach

                            @error('selected_units')
                                <div class="mt-1 small text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button id="unit" type="submit" class='btn btn-primary w-100'>
                                {{ __('Save') }}
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script type="text/javascript">
        const confirm_payment_button = document.querySelector('button#confirm_payment')
        const confirmation_button = document.querySelector('button#confirmation')
        const cancel_button = document.querySelector('button#cancel')
        const unit_button = document.querySelector('button#unit')

        if (confirm_payment_button)
            confirm_payment_button.addEventListener('click', (e) => {
                e.preventDefault()
                Swal.fire({
                    title: "{{ __('Confirmation!') }}",
                    text: "{{ __('Are you sure you want to confirm payment the :feature?', ['feature' => __('Reservation')]) }}",
                    icon: 'warning',
                    timer: 0,
                    toast: false,
                    position: 'center',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('Yes, do it!') }}',
                    showCancelButton: true,
                    cancelButtonText: '{{ __('No, cancel!') }}',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.closest('form').submit()
                    }
                })
            })

        if (confirmation_button)
            confirmation_button.addEventListener('click', (e) => {
                e.preventDefault()
                Swal.fire({
                    title: "{{ __('Confirmation!') }}",
                    text: "{{ __('Are you sure you want to confirmation the :feature?', ['feature' => __('Reservation')]) }}",
                    icon: 'warning',
                    timer: 0,
                    toast: false,
                    position: 'center',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('Yes, do it!') }}',
                    showCancelButton: true,
                    cancelButtonText: '{{ __('No, cancel!') }}',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.closest('form').submit()
                    }
                })
            })

        if (cancel_button)
            cancel_button.addEventListener('click', (e) => {
                e.preventDefault()
                Swal.fire({
                    title: "{{ __('Confirmation!') }}",
                    text: "{{ __('Are you sure you want to cancel the :feature?', ['feature' => __('Reservation')]) }}",
                    icon: 'warning',
                    timer: 0,
                    toast: false,
                    position: 'center',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('Yes, do it!') }}',
                    showCancelButton: true,
                    cancelButtonText: '{{ __('No, cancel!') }}',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.closest('form').submit()
                    }
                })
            })

        if (unit_button)
            unit_button.addEventListener('click', (e) => {
                e.preventDefault()
                Swal.fire({
                    title: "{{ __('Confirmation!') }}",
                    text: "{{ __('Are you sure you want to update the :feature?', ['feature' => __('Select Units')]) }}",
                    icon: 'warning',
                    timer: 0,
                    toast: false,
                    position: 'center',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('Yes, do it!') }}',
                    showCancelButton: true,
                    cancelButtonText: '{{ __('No, cancel!') }}',
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.closest('form').submit()
                    }
                })
            })
    </script>
@endpush

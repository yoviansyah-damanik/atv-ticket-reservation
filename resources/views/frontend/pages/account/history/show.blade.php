@extends('frontend.layouts.account')

@section('title', __('Account'))

@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <a href="{{ route('account.history') }}" class="btn btn-sm btn-light mb-3">
            <i class="bi bi-arrow-return-left"></i>
            {{ __('Back') }}
        </a>

        <div class="text-right">
            @if ($previous)
                <a href="{{ route('account.history.show', $previous->id) }}" class="btn btn-sm btn-primary mb-3">
                    <i class="bi bi-arrow-left"></i>
                    {{ __('Previous') }}
                </a>
            @endif
            @if ($next)
                <a href="{{ route('account.history.show', $next->id) }}" class="btn btn-sm btn-primary mb-3">
                    {{ __('Next') }}
                    <i class="bi bi-arrow-right"></i>
                </a>
            @endif
        </div>
    </div>
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

                <h6>{{ __('Package Details') }}</h6>
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
                <div class="text-right">
                    @if ($reservation->status == 'waiting_for_payment')
                        <form action="{{ route('account.history.show.cancel', $reservation->id) }}" method="post">
                            @csrf
                            @method('put')
                            <button id="cancel-item" type="button" class="btn btn-sm btn-danger">
                                {{ __('Cancel Reservation') }}
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if ($reservation->status == 'waiting_for_payment' && $reservation?->payment?->status != 'wait_for_confirmation')
        <div class="card">
            <div class="card-body">
                <h5>
                    {{ __('Payment Information') }}
                </h5>
                <ol class="list-group list-group-flush my-3">
                    <li class="list-group-item">
                        1. {{ __('Customers can choose one of the available payment types.') }}
                    </li>
                    <li class="list-group-item">
                        2. {{ __('Make sure the payment amount matches what is stated on the form.') }}
                    </li>
                    <li class="list-group-item">
                        3.
                        {{ __("After making payment, Customers are required to send proof of payment via the 'Send Proof of Payment' button on this form.") }}
                    </li>
                </ol>
                <form class="mt-4" action="{{ route('account.history.show.payment', $reservation->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="mb-3">
                        @foreach ($payment_vendors as $payment_vendor)
                            <div class="payment-vendor-radio">
                                <input type="radio" value="{{ $payment_vendor->id }}"
                                    id="payment-vendor-{{ $payment_vendor->id }}" name='selected_payment_vendor'
                                    @if (old('selected_payment_vendor') == $payment_vendor->id) checked @endif required>
                                <label for="payment-vendor-{{ $payment_vendor->id }}">
                                    <div class="img-box">
                                        <img src="{{ $payment_vendor->image_path }}" alt="Payment Vendor Image">
                                    </div>
                                    <div class="body">
                                        <div class="title">
                                            {{ $payment_vendor->name }}
                                        </div>
                                        <div class="account_number">
                                            {{ $payment_vendor->account_number }}
                                        </div>
                                        <div class="description">
                                            {{ $payment_vendor->description }}
                                        </div>
                                    </div>
                                </label>
                            </div>
                        @endforeach
                        @error('selected_payment_vendor')
                            <div class="mt-1 small text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="proof_of_payment">{{ __('Proof of Payment') }} <span
                                class="text-danger">*{{ __('Optional') }}</span></label>
                        <input type="file" class="form-control" name="proof_of_payment" id="proof_of_payment"
                            accept="image/*">
                        @error('proof_of_payment')
                            <div class="mt-1 small text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Send Proof of Payment') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @elseif($reservation->status == 'waiting_for_payment' && $reservation?->payment?->status == 'wait_for_confirmation')
        <div class="alert alert-warning d-flex align-items-center" role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
                aria-label="Warning:">
                <path
                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
            </svg>
            <div>
                {{ __('Your payment is currently being checked by the Administrator.') }}
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script type="text/javascript">
        const cancelItem = (el) => {
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
                    el.closest('form').submit()
                }
            })
        }

        $('#cancel-item').on('click', (e) => {
            e.preventDefault()
            cancelItem($('#cancel-item'))
        })
    </script>
@endpush

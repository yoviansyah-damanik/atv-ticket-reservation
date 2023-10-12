<html>

<head>

    <head>
        <style>
            html {
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
            }

            .box-bordered {
                border: 1px solid #ddd;
                padding: 1.5rem;
                width: 100%;
                max-width: 820px;
            }

            h5 {
                font-size: 1.4em;
                margin: 0;
            }

            .text-center {
                text-align: center;
            }

            .text-start {
                text-align: left;
            }

            .text-end {
                text-align: right;
            }

            .font-bold {
                font-weight: bold;
            }

            .font-bolder {
                font-weight: bolder;
            }

            .font-lighter {
                font-weight: lighter;
            }

            .text-uppercase {
                text-transform: uppercase;
            }

            table {
                width: 100%;
            }

            table thead {
                vertical-align: middle;
            }

            table.bordered {
                margin-top: 1rem;
                border-collapse: collapse;
            }

            table.bordered th {
                text-align: center;
            }

            table.bordered td,
            table.bordered th {
                border: 1px solid #ddd;
                padding: 3px;
            }

            table.bordered th {
                padding-top: 12px;
                padding-bottom: 12px;
                background-color: #EF8641;
            }

            table.bordered td {
                vertical-align: top;
            }

            .page-break {
                page-break-after: always;
            }

            .page-break-inside-avoid {
                page-break-inside: avoid;
            }

            .logo {
                position: relative;
                width: 150px;
            }

            .valign-middle {
                vertical-align: middle !important;
            }

            .mt-3 {
                margin-top: 1.5rem;
            }

            .mt-4 {
                margin-top: 2rem;
            }

            .mb-0 {
                margin-bottom: 0;
            }

            p {
                margin: 0;
                line-height: 1.5;
            }

            .italic {
                font-style: italic;
            }
        </style>
    </head>
</head>

<body>
    <div class="box-bordered w-100">
        <h5>#{{ $reservation->id }}</h5>

        <div class="mt-3">
            <p>
                <strong>{{ __('Orderer Name') }}:</strong> {{ $reservation->orderer_name }}
            </p>
            <p>
                <strong>{{ __('Total Package') }}:</strong> {{ $reservation->details->sum('amount') }}
            </p>

            <p>
                <strong>{{ __('Reservation Date') }}:</strong>
                {{ Carbon::parse($reservation->date)->translatedFormat('d F Y') }}
            </p>
            <p>
                <strong>{{ __('Expectation Time') }}:</strong>
                {{ Carbon::parse($reservation->time)->format('H:i') }} WIB
            </p>
        </div>

        <div class="mt-3">
            <strong>{{ __('Status') }}:</strong>
            @if ($reservation->status == 'waiting_for_payment')
                {{ __('Waiting for Payment') }}
            @elseif($reservation->status == 'ready_for_action')
                {{ __('Ready for Action') }}
            @elseif($reservation->status == 'canceled')
                {{ __('Reservation Canceled') }}
            @else
                {{ __('Reservation Completed') }}
            @endif
        </div>

        <div class="mt-3">
            <table class="bordered">
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
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $item->package->title }}
                            </td>
                            <td class="text-center">
                                {{ PriceHelper::idr($item->price, 0, true) }}
                            </td>
                            <td class="text-center">
                                {{ $item->amount }}
                            </td>
                            <td class="text-center">
                                {{ PriceHelper::idr($item->total_payment, 0, true) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3 text-end">
                <strong>{{ __('Total Payment') }}</strong>
                <h5>
                    {{ PriceHelper::idr($reservation->details->sum('total_payment'), 0, true) }}
                </h5>
            </div>
        </div>

        <p class="mt-3">
            Segera lakukan pembayaran terhadap reservasi yang dilakukan melalui link berikut ini.
        </p>
        <a href="{{ route('account.history.show', $reservation->id) }}"
            target="_blank">{{ route('account.history.show', $reservation->id) }}</a>

        <p class="mt-3 italic">
            Mohon untuk tidak membalas pesan ini. Pesan ini dikirimkan secara otomatis oleh aplikasi ATV Adventure Kota
            Padangsidimpuan.
        </p>
    </div>
</body>

</html>

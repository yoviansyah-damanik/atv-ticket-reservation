<!DOCTYPE html>
<html>

<head>
    <style>
        html {
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
            margin: 1cm;
        }

        h5 {
            font-size: 1.4em;
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
            border: 1px solid #607080;
            padding: 3px;
        }

        table.bordered th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #f8b384;
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
            width: 80px;
        }

        .valign-middle {
            vertical-align: middle !important;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .w-100 {
            width: 100%;
        }
    </style>
</head>

<body>
    <img style="float:left" src="{{ asset('branding-assets/img/logo-min.png') }}" alt="Logo" class="logo">
    <div style="float:right" class="w-100 text-end">
        <h5>
            {{ __('Reservation Report for :year', ['year' => $year]) }}
        </h5>
    </div>

    <div style="clear: both" class="mt-4">
        <table class="bordered">
            <thead class="text-center">
                <tr>
                    <th rowspan=2>#</th>
                    <th rowspan=2>{{ __('Month') }}</th>
                    <th colspan="{{ count(ReservationType::getValues()) }}">{{ __('Status') }}</th>
                    <th rowspan=2>{{ __('Total') }}</th>
                </tr>
                <tr>
                    <th width=90px>{{ __('Waiting for Payment') }}</th>
                    <th width=90px>{{ __('Ready for Action') }}</th>
                    <th width=90px>{{ __('Completed') }}</th>
                    <th width=90px>{{ __('Canceled') }}</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item['month_name'] }}</td>
                        <td class="text-center">
                            {{ $item['reservations'][ReservationType::WaitingForPayment] }}
                        </td>
                        <td class="text-center">
                            {{ $item['reservations'][ReservationType::ReadyForAction] }}
                        </td>
                        <td class="text-center">
                            {{ $item['reservations'][ReservationType::Completed] }}
                        </td>
                        <td class="text-center">
                            {{ $item['reservations'][ReservationType::Canceled] }}
                        </td>
                        <td class="text-center">
                            {{ collect($item['reservations'])->sum(fn($q) => $q) }}
                        </td>
                    </tr>
                @endforeach
                <tr class="font-bold">
                    <td class="text-end" colspan="2">
                        {{ __('Total') }}
                    </td>
                    <td class="text-center">
                        {{ collect($data)->sum(fn($q) => $q['reservations'][ReservationType::WaitingForPayment]) }}
                    </td>
                    <td class="text-center">
                        {{ collect($data)->sum(fn($q) => $q['reservations'][ReservationType::ReadyForAction]) }}
                    </td>
                    <td class="text-center">
                        {{ collect($data)->sum(fn($q) => $q['reservations'][ReservationType::Completed]) }}
                    </td>
                    <td class="text-center">
                        {{ collect($data)->sum(fn($q) => $q['reservations'][ReservationType::Canceled]) }}
                    </td>
                    <td class="text-center">
                        {{ collect($data)->sum(fn($q) => collect($q['reservations'])->sum(fn($r) => $r)) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

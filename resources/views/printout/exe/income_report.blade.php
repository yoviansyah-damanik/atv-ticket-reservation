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
            {{ __('Income Report for :year', ['year' => $year]) }}
        </h5>
    </div>

    <div style="clear: both" class="mt-4">
        <table class="bordered">
            <thead class="text-center">
                <th width=30px>#</th>
                <th>{{ __('Month') }}</th>
                <th width=300px>
                    {{ __('Total Income') }}
                </th>
            </thead>

            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $item['month_name'] }}</td>
                        <td class="text-end">{{ PriceHelper::idr($item['income'], 0, true) }}</td>
                    </tr>
                @endforeach
                <tr class="font-bold">
                    <td class="text-end" colspan="2">
                        {{ __('Total Income') }}
                    </td>
                    <td class="text-end">
                        {{ PriceHelper::idr(collect($data)->sum(fn($q) => $q['income']), 0, true) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

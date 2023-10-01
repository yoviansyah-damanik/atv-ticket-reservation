<div class="table-responsive">
    <table class="table">
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
            <tr class="fw-bold">
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

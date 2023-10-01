<div class="table-responsive">
    <table class="table">
        <thead class="text-center">
            <th width=30px>#</th>
            <th>{{ __('Month') }}</th>
            <th width=300px>
                {{ __('Total Revenue') }}
            </th>
        </thead>

        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item['month_name'] }}</td>
                    <td class="text-end">{{ PriceHelper::idr($item['revenue'], 0, true) }}</td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td class="text-end" colspan="2">
                    {{ __('Total Revenue') }}
                </td>
                <td class="text-end">
                    {{ PriceHelper::idr(collect($data)->sum(fn($q) => $q['revenue']), 0, true) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

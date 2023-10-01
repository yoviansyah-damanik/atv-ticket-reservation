<div class="table-responsive">
    <table class="table">
        <thead class="text-center">
            <tr>
                <th width=30px rowspan=2>#</th>
                <th width=150px rowspan=2>{{ __('Unit Name') }}</th>
                <th colspan="{{ count($period) }}">
                    {{ Carbon::createFromFormat('m', $month)->translatedFormat('F') }}
                </th>
                <th rowspan=2>
                    {{ __('Total') }}
                </th>
            </tr>
            <tr>
                @foreach ($period as $item)
                    <th>
                        {{ Carbon::parse($item)->format('d') }}
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $item['unit_name'] }}</td>
                    @foreach ($item['unit_usage'] as $usage)
                        <td class="text-center">{{ $usage['count'] }}</td>
                    @endforeach
                    <td class="text-center">
                        {{ collect($item['unit_usage'])->sum('count') }}
                    </td>
                </tr>
            @endforeach
            <tr class="fw-bold">
                <td class="text-end" colspan="{{ count($period) + 2 }}">
                    {{ __('Total Unit Usage') }}
                </td>
                <td class="text-center">
                    {{ collect($data)->sum(fn($q) => collect($q['unit_usage'])->sum('count')) }}
                </td>
            </tr>
        </tbody>
    </table>
</div>

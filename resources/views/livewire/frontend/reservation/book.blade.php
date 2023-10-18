<div class="row">
    <div class="col-lg-7">
        <div class="py-4 px-3">
            <div class="text-danger mb-3">
                (*) {{ __('Required') }}
            </div>
            <div class="mb-3">
                <label class='form-label' for="orderer_name">{{ __('Orderer Name') }} <span
                        class="text-danger">(*)</span></label>
                <input type="text" wire:model.live='orderer_name'
                    class="form-control  @error('orderer_name') is-invalid @enderror"
                    placeholder="{{ __('Orderer Name') }}">
                @error('orderer_name')
                    <div class="mt-1 small text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <div wire:ignore>
                    <label class='form-label' for="date">{{ __('Date') }} <span
                            class="text-danger">(*)</span></label>
                    <input wire:model.live='date' type='text'
                        class="form-control datepicker @error('date') is-invalid @enderror"
                        style="background-color:#fff; cursor:pointer;" placeholder="{{ __('Select a date') }}" readonly>
                </div>
                @error('date')
                    <div class="mt-1 small text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label class='form-label' for="time">{{ __('Expectation Time') }} <span
                        class="text-danger">(*)</span></label>
                <select wire:model.live='time' class="form-select @error('time') is-invalid @enderror"
                    placeholder="{{ __('Expecation Time') }}">
                    @foreach ($times as $item)
                        <option value="{{ $item }}">{{ $item }} WIB</option>
                    @endforeach
                </select>
                <div class="mt-1 small text-muted">
                    {{ __('Expected time is the time you estimate to arrive at the location and use the unit. The time of this hope is not fixed. You can change the time according to your wishes when you arrive at the location on the date you have set.') }}
                </div>
                @error('time')
                    <div class="mt-1 small text-danger">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <h6>{{ __('Select the package you want to order.') }}</h6>
                <div class="row">
                    @foreach ($packages as $idx => $package)
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="package-checkbox">
                                <input type="checkbox" id="package-{{ $idx }}"
                                    wire:model.live='selected_package.{{ $idx }}'>
                                <label for="package-{{ $idx }}">
                                    <div class="img-box">
                                        <img src="{{ $package->image_path }}" alt="Package Image">
                                    </div>
                                    <div class="title">
                                        {{ $package->title }}
                                    </div>
                                    <div class="price">
                                        {{ PriceHelper::idr($package->price, 0, true) }}
                                    </div>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="p-4"
            style="background: linear-gradient(var(--section-primary), var(--section-primary)); position:sticky; top: 6rem;">
            <h5 class="mb-4">{{ __('Transaction Detail') }}</h5>

            <table class="table table-bordered">
                <tr>
                    <th colspan=2>{{ __('Orderer Name') }}</th>
                    <td colspan=2>{{ $orderer_name }}</td>
                </tr>
                <tr>
                    <th colspan=2>{{ __('Date') }}</th>
                    <td colspan=2>
                        {{ $date ? Carbon::createFromFormat('d/m/Y', $date)->translatedFormat('l, d M Y') : __('No date selected') }}
                    </td>
                </tr>
                <tr>
                    <th colspan=2>{{ __('Expectation Time') }}</th>
                    <td colspan=2>{{ Carbon::parse($time)->translatedFormat('H:i') }} WIB</td>
                </tr>
                <tr>
                    <th class="text-center" colspan=4>{{ __('Reservation Detail') }}</th>
                </tr>
                @forelse ($selected_packages_show as $item)
                    <tr>
                        <td class="text-center" width=30px>{{ $loop->iteration }}</td>
                        <td colspan=2>{{ $item['title'] }} <span
                                class="fst-italic small">{{ '@' . PriceHelper::idr($item['price'], 0, true) }}</span>
                        </td>
                        <td width=120px>
                            <div class="d-flex align-items-center">
                                <button class="btn btn-sm btn-danger p-0"
                                    style="width:50px !important; aspect-ratio:1/1;"
                                    wire:click='decrement({{ $item['selected_id'] }})' wire:loading.attr='disabled'
                                    wire:target='increment,decrement'>-</button>
                                <span
                                    class="w-100 text-center bg-white py-1">{{ $selected_package[$item['selected_id']]['amount'] }}</span>
                                <button class="btn btn-sm btn-danger p-0"
                                    style="width:50px !important; aspect-ratio:1/1;"
                                    wire:click='increment({{ $item['selected_id'] }})' wire:loading.attr='disabled'
                                    wire:target='increment,decrement'>+</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan=4>
                            {{ __('No data found.') }}
                        </td>
                    </tr>
                @endforelse
                <tr>
                    <th colspan=2>{{ __('Total Package') }}</th>
                    <th colspan=2 class="text-end">{{ PriceHelper::idr($total_package) }}</th>
                </tr>
                <tr>
                    <th colspan=2>{{ __('Total Payment') }}</th>
                    <th colspan=2 class="text-end">{{ PriceHelper::idr($total_payment, 0, true) }}</th>
                </tr>
            </table>
            @error('selected_package')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
            @error('selected_package.*.amount')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
            <div class="mt-4">
                <button class="btn btn-primary w-100" wire:click='store_reservation' wire:loading.attr='disabled'>
                    {{ __('Book Now') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script type="text/javascript">
        $(".datepicker").datepicker({
            numberOfMonths: 3,
            dateFormat: "dd/mm/yy",
            changeMonth: true,
            changeYear: true,
            minDate: '{{ date('d/m/Y') }}',
            beforeShowDay: function(date) {
                var day = date.getDay();
                return [day == 6 || day == 0, ''];
            },
            onSelect: function(a, b) {
                @this.set('date', a)
            }
        });
    </script>
@endpush

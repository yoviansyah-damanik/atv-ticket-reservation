<div>
    @if (empty($month) && empty($year))
        {{ __('Please select the period to be displayed.') }}
    @else
        <div class="border-bottom text-end pb-3">
            <button class="btn btn-danger" wire:click='refresh' wire:loading.attr='disabled' wire:target='print'>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-rotate" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M19.95 11a8 8 0 1 0 -.5 4m.5 5v-5h-5"></path>
                </svg>
                {{ __('Reset') }}</button>
            <button class="btn btn-primary" wire:click='print' wire:loading.attr='disabled' wire:target='print'>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-printer" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M17 17h2a2 2 0 0 0 2 -2v-4a2 2 0 0 0 -2 -2h-14a2 2 0 0 0 -2 2v4a2 2 0 0 0 2 2h2"></path>
                    <path d="M17 9v-4a2 2 0 0 0 -2 -2h-6a2 2 0 0 0 -2 2v4"></path>
                    <path d="M7 13m0 2a2 2 0 0 1 2 -2h6a2 2 0 0 1 2 2v4a2 2 0 0 1 -2 2h-6a2 2 0 0 1 -2 -2z"></path>
                </svg>
                {{ __('Print') }}
            </button>
            <div class="w-100" wire:loading.block>
                <div class="progress">
                    <div class="progress-bar progress-bar-indeterminate bg-primary"></div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if ($month != 'all')
                    @include('printout.preview.reservation_report', [
                        'data' => $data,
                        'month' => $month,
                        'year' => $year,
                        'period' => $period,
                    ])
                @else
                    @include('printout.preview.reservation_all_report', [
                        'data' => $data,
                        'year' => $year,
                        'period' => $period,
                    ])
                @endif
            </div>
        </div>
    @endif
</div>

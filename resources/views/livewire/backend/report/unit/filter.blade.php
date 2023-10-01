<div class="card">
    <div class="card-body border-bottom py-3">
        <div class="mb-3">
            <label for="month" class="form-label">{{ __('Month') }}</label>
            <select class="form-select" wire:model='month' wire:loading.attr='disabled' wire:target='preview'>
                <option value="all">
                    {{ __('All months') }}</option>
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}">
                        {{ Carbon::createFromFormat('m', $month)->translatedFormat('F') }}</option>
                @endforeach
            </select>
            @error('month')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">{{ __('Year') }}</label>
            <select class="form-select" wire:model='year' wire:loading.attr='disabled' wire:target='preview'>
                @foreach (range(date('Y'), 2023) as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            @error('year')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="card-footer text-end">
        <button class="btn btn-primary" wire:click='preview' wire:loading.attr='disabled'>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-zoom-check" width="24"
                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                <path d="M21 21l-6 -6"></path>
                <path d="M7 10l2 2l4 -4"></path>
            </svg>
            {{ __('Preview') }}
        </button>
    </div>
</div>

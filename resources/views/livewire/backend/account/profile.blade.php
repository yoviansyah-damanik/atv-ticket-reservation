<div class="card">
    <div class="card-body">
        <h3 class="mb-3">{{ __('Account Information') }}</h3>
        @csrf
        @method('put')
        <div class="mb-3">
            <label for="username" class="form-label">{{ __('Username') }}</label>
            <input type="text" wire:model="username" wire:loading.attr='disabled' wire:target='save_profile'
                id="username" class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username', Auth::user()->username) }}" required>
            @error('username')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Full Name') }}</label>
            <input type="text" wire:model="name" wire:loading.attr='disabled' wire:target='save_profile'
                id="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', Auth::user()->name) }}" required>
            @error('name')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" wire:model="email" wire:loading.attr='disabled' wire:target='save_profile'
                id="email" class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', Auth::user()->email) }}" required>
            @error('email')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary" wire:click='save_profile' wire:loading.attr='disabled'>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-square-rounded-chevron-down"
                    width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M15 11l-3 3l-3 -3"></path>
                    <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z"></path>
                </svg>
                {{ __('Save') }}
            </button>
        </div>
    </div>
</div>

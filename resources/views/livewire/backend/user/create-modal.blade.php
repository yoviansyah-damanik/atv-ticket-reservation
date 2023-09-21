<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">
            {{ __('Create :create', ['create' => __('User')]) }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label" for="username">{{ __('Username') }} <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control" id="username" wire:model='username'
                placeholder="{{ __('Username') }}">
            @error('username')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }} <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control" id="name" wire:model='name'
                placeholder="{{ __('Name') }}">
            @error('name')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">{{ __('Email') }} <span class="text-danger">(*)</span></label>
            <input type="email" class="form-control" id="email" wire:model='email'
                placeholder="{{ __('Email') }}">
            @error('email')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="role">{{ __('Role') }} <span class="text-danger">(*)</span></label>
            <select class="form-select" id="role" wire:model='role'>
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('role')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">{{ __('Password') }} <span class="text-danger">(*)</span></label>
            <input type="password" class="form-control" id="password" wire:model='password'
                placeholder="{{ __('Password') }}">
            @error('password')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="re_password">{{ __('Re-Password') }} <span
                    class="text-danger">(*)</span></label>
            <input type="password" class="form-control" id="re_password" wire:model='re_password'
                placeholder="{{ __('Password') }}">
            @error('re_password')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <span class="text-danger">(*) {{ __('Required') }}</span>
    </div>
    <div class="modal-footer">
        <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            {{ __('Close') }}
        </a>
        <button class="btn btn-primary ms-auto" wire:click='store'>
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            {{ __('Create :create', ['create' => __('User')]) }}
        </button>
        <div class="w-100" wire:loading.block>
            <div class="progress">
                <div class="progress-bar progress-bar-indeterminate bg-primary"></div>
            </div>
        </div>
    </div>
</div>

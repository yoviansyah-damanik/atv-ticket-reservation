<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">
            {{ __('Create :create', ['create' => __('Unit')]) }}
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="mb-3">
            <label class="form-label" for="image">{{ __('Image') }} </label>
            <input type="file" class="form-control" id="image" wire:model='image' accept="image/*"
                placeholder="{{ __('Image') }}" wire:loading.attr='disabled'>
            @error('image')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="name">{{ __('Name') }} <span class="text-danger">(*)</span></label>
            <input type="text" class="form-control" id="name" wire:model='name'
                placeholder="{{ __('Unit Name') }}">
            @error('name')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="register_number">{{ __('Register Number') }} <span
                    class="text-danger">(*)</span></label>
            <input type="text" class="form-control" id="register_number" wire:model='register_number'
                placeholder="{{ __('Register Number') }}">
            @error('register_number')
                <div class="mt-1 small text-danger">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">{{ __('Description') }}</label>
            <input type="text" class="form-control" id="description" wire:model='description'
                placeholder="{{ __('Description') }}">
            @error('description')
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
            {{ __('Create :create', ['create' => __('Unit')]) }}
        </button>
        <div class="w-100" wire:loading.block>
            <div class="progress">
                <div class="progress-bar progress-bar-indeterminate bg-primary"></div>
            </div>
        </div>
    </div>
</div>

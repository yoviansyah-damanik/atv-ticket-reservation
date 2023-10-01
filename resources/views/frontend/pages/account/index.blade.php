@extends('frontend.layouts.account')

@section('title', __('Account'))

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="mb-3">{{ __('Account Information') }}</h5>
            <form action="{{ route('account.update') }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="username" class="form-label">{{ __('Username') }}</label>
                    <input type="text" name="username" id="username"
                        class="form-control @error('username') is-invalid @enderror"
                        value="{{ old('username', Auth::user()->username) }}" required>
                    @error('username')
                        <div class="mt-1 small text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Full Name') }}</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', Auth::user()->name) }}" required>
                    @error('name')
                        <div class="mt-1 small text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input type="email" name="email" id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', Auth::user()->email) }}" required>
                    @error('email')
                        <div class="mt-1 small text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <h5 class="mb-3">{{ __('Password') }}</h5>
            <form action="{{ route('account.update.password') }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                    <input type="password" name="current_password" id="current_password"
                        class="form-control @error('current_password') is-invalid @enderror" required>
                    @error('current_password')
                        <div class="mt-1 small text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                    <input type="password" name="new_password" id="new_password"
                        class="form-control @error('new_password') is-invalid @enderror" required>
                    <div class="text-muted small mt-1">
                        {{ __('Password consist of a combination of letters and numbers.') }}
                    </div>
                    <div class="text-muted small mt-1">
                        {{ __('Password must be at least 8 characters.') }}
                    </div>
                    @error('new_password')
                        <div class="mt-1 small text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="re_password" class="form-label">{{ __('Re-Password') }}</label>
                    <input type="password" name="re_password" id="re_password"
                        class="form-control @error('re_password') is-invalid @enderror" required>
                    @error('re_password')
                        <div class="mt-1 small text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i>
                        {{ __('Save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

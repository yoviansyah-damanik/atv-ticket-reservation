@extends('auth.layouts.app')

@section('content')
    <div class="auth">
        <div class="auth-form">
            <a href="{{ route('home') }}">
                <img class="auth-logo" src="{{ asset('branding-assets/img/logo.png') }}">
            </a>
            <div class="col-8">
                <h5 class="text-primary">{{ __('Register') }}</h5>
                <div class="small text-muted">
                    {{ __('Register your account for ease of ordering.') }}
                </div>
            </div>

            <form class="mt-4" action="{{ route('register.do') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="username">{{ __('Username') }}</label>
                    <input type="text" name="username" id="username" class="form-control" required autofocus
                        value="{{ old('username') }}">
                    <div class="text-muted small mt-1">
                        {{ __("Username must be at least 8 characters, no spaces, and no symbols (except '-' and '_').") }}
                    </div>
                    @error('username')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="name">{{ __('Full Name') }}</label>
                    <input type="text" name="name" id="name" class="form-control" required autofocus
                        value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="email">{{ __('Email') }}</label>
                    <input type="text" name="email" id="email" class="form-control" required autofocus
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div class="text-muted small mt-1">
                        {{ __('Password consist of a combination of letters and numbers.') }}
                    </div>
                    <div class="text-muted small mt-1">
                        {{ __('Password must be at least 8 characters.') }}
                    </div>
                    @error('password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="re_password">{{ __('Re-Password') }}</label>
                    <input type="password" name="re_password" id="re_password" class="form-control" required>
                    @error('re_password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary w-100">
                        {{ __('Register') }}
                    </button>
                    <div class="text-center mt-2">
                        <a href="{{ route('login') }}">
                            {{ __('Already have an account?') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

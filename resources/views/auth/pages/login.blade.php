@extends('auth.layouts.app')

@section('content')
    <div class="auth">
        <div class="auth-form">
            <a href="{{ route('home') }}">
                <img class="auth-logo" src="{{ asset('branding-assets/img/logo.png') }}">
            </a>
            <div class="col-8">
                <h5 class="text-primary">{{ __('Log In') }}</h5>
                <div class="small text-muted">
                    {{ __('Please log in first.') }}
                </div>
            </div>

            <form class="mt-4" action="{{ route('login.do') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="username">{{ __('Username') }}</label>
                    <input type="text" name="username" id="username" class="form-control" value="{{ old('username') }}"
                        required autofocus>
                    @error('username')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="password">{{ __('Password') }}</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember_me" id="remember_me">
                            <label class="form-check-label" for="remember_me">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                        <a href="{{ route('register') }}">
                            {{ __('Forgot password?') }}
                        </a>
                    </div>
                </div>
                <div class="mt-4">
                    <button class="btn btn-primary w-100">
                        {{ __('Log In') }}
                    </button>
                    <div class="text-center mt-2">
                        <a href="{{ route('register') }}">
                            {{ __('Don\'t have an account?') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

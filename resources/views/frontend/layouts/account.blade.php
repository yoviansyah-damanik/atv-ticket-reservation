<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>{{ config('app.name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link rel="shortcut icon" href="{{ asset('branding-assets/img/logo-min.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Playfair+Display:wght@700;900&display=swap"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="{{ asset('frontend-assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">
    @livewireStyles
    @stack('styles')
</head>

<body>
    @include('sweetalert::alert')
    @include('frontend.partials.loading')

    @include('frontend.partials.navbar')

    <div class="container container-padding">
        <div class="row">
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <div class="account-box">
                            <img src="{{ Auth::user()->image_path }}" alt="User Image">
                            <h5>{{ Auth::user()->name }}</h5>
                            <p class="username">{{ Auth::user()->username }}</p>
                            <p class="email">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link  @if (request()->routeIs('account.history*')) active @endif" aria-current="page"
                            href="{{ route('account.history') }}">{{ __('History') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if (request()->routeIs('account')) active @endif" aria-current="page"
                            href="{{ route('account') }}">{{ __('Account') }}</a>
                    </li>
                </ul>
                <div class="py-3 px-2">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    @include('frontend.partials.footer')
    @include('frontend.partials.backToTop')
    @include('frontend.partials.js')
</body>

</html>

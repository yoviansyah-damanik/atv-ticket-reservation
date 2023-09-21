<!doctype html>
<html lang="{{ config('app.locale') ?? 'en' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('branding-assets/img/logo-min.png') }}" type="image/x-icon">
    <link href="{{ asset('backend-assets/css/tabler.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend-assets/css/tabler-flags.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend-assets/css/tabler-payments.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend-assets/css/tabler-vendors.min.css?1684106062') }}" rel="stylesheet" />
    <link href="{{ asset('backend-assets/css/demo.min.css?1684106062') }}" rel="stylesheet" />
    @livewireStyles
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <script src="{{ asset('backend-assets/js/demo-theme.min.js?1684106062') }}"></script>
    <div class="page">
        @include('backend.partials.navbar')
        <div class="page-wrapper">
            @yield('content')
            @include('backend.partials.footer')
        </div>
    </div>
    @include('backend.partials.js')
</body>

</html>

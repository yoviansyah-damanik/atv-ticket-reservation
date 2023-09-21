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
    <link href="{{ asset('frontend-assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/css/style.css') }}" rel="stylesheet">
</head>

<body>
    @include('sweetalert::alert')
    @include('frontend.partials.loading')

    @yield('content')

    @include('frontend.partials.js')
</body>

</html>

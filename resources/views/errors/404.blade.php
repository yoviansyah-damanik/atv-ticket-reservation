@extends('frontend.layouts.app')

@section('content')
    <div class="container container-padding">
        <div id="notfound">
            <div class="notfound">
                <div class="notfound-404">
                    <h1>Oops!</h1>
                    <h2>404 - {{ __("The Page can't be found") }}</h2>
                </div>
                <a href="{{ route('home') }}">{{ __('Go To Homepage') }}</a>
            </div>
        </div>
    </div>
@endsection

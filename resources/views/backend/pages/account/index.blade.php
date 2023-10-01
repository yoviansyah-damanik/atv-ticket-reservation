@extends('backend.layouts.app')

@section('title', __('Account'))
@section('content')
    <div>
        {{-- Page header  --}}
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        {{-- Page pre-title  --}}
                        <h2 class="page-title">
                            {{ __('Account') }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        {{-- Page body  --}}
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-lg-6">
                        <livewire:backend.account.profile />
                    </div>
                    <div class="col-lg-6">
                        <livewire:backend.account.password />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

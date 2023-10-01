@extends('backend.layouts.app', ['layout' => 'fluid'])

@section('title', __('Unit Report'))
@section('content')
    <div>
        {{-- Page header  --}}
        <div class="page-header d-print-none">
            <div class="container-xl">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        {{-- Page pre-title  --}}
                        <h2 class="page-title">
                            {{ __('Unit Report') }}
                        </h2>
                        <p class="text-muted small">
                            {{ __('See the unit usage report on :1.', ['1' => config('app.name')]) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Page body  --}}
        <div class="page-body">
            <div class="container-xl">
                <div class="row row-cards">
                    <div class="col-lg-3">
                        <livewire:backend.report.unit.filter />
                    </div>
                    <div class="col-lg-9">
                        <livewire:backend.report.unit.preview />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('frontend.layouts.app')

@section('content')
    <div class="container container-padding">
        <div class="row">
            <div class="col-lg-8 order-1 order-lg-0">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('reservation.store') }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for=""></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 order-0 order-lg-1"></div>
        </div>
    </div>
@endsection

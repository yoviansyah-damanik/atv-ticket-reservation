@extends('backend.layouts.app')

@section('title', __('Payment Vendor'))
@section('content')
    <livewire:backend.payment-vendor.index />

    <div class="modal modal-blur fade" id="create-payment-vendor-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.payment-vendor.create-modal />
        </div>
    </div>
    <div class="modal modal-blur fade" id="edit-payment-vendor-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.payment-vendor.edit-modal />
        </div>
    </div>
@endsection

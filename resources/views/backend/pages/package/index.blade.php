@extends('backend.layouts.app')

@section('title', __('Package'))
@section('content')
    <livewire:backend.package.index />

    <div class="modal modal-blur fade" id="create-package-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.package.create-modal />
        </div>
    </div>
    <div class="modal modal-blur fade" id="edit-package-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.package.edit-modal />
        </div>
    </div>
@endsection

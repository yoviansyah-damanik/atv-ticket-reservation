@extends('backend.layouts.app')

@section('title', __('Unit'))
@section('content')
    <livewire:backend.unit.index />

    <div class="modal modal-blur fade" id="create-unit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.unit.create-modal />
        </div>
    </div>
    <div class="modal modal-blur fade" id="edit-unit-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.unit.edit-modal />
        </div>
    </div>
@endsection

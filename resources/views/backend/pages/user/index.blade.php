@extends('backend.layouts.app')

@section('title', __('User'))
@section('content')
    <livewire:backend.user.index />

    <div class="modal modal-blur fade" id="create-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.user.create-modal />
        </div>
    </div>
    <div class="modal modal-blur fade" id="edit-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <livewire:backend.user.edit-modal />
        </div>
    </div>
@endsection

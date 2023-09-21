<div>
    {{-- Page header  --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    {{-- Page pre-title  --}}
                    <h2 class="page-title">
                        {{ __('Payment Vendor') }}
                    </h2>
                </div>
                {{-- Page title actions  --}}
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            wire:click="$dispatch('refresh_create_form')" data-bs-target="#create-payment-vendor-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            {{ __('Create :create', ['create' => __('Payment Vendor')]) }}
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#create-payment-vendor-modal" wire:click="$dispatch('refresh_create_form')"
                            aria-label="{{ __('Create :create', ['create' => __('Payment Vendor')]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Page body  --}}
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ __(':data Data', ['data' => __('Payment Vendor')]) }}</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    {{ __('Show') }}
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.lazy="show" size="3" wire:change='set_reset_page'>
                                    </div>
                                    {{ __('entries') }}
                                </div>
                                <div class="ms-auto text-muted">
                                    {{ __('Search:') }}
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" aria-label="Search"
                                            wire:model.live="search" wire:change='set_reset_page'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Account Number') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payment_vendors as $payment_vendor)
                                        <tr>
                                            <td>
                                                {{ $payment_vendors->perPage() * ($payment_vendors->currentPage() - 1) + $loop->iteration }}
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar me-2"
                                                        style="background-image: url({{ $payment_vendor->image_path }}); --tblr-avatar-size:6rem"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium"> {{ $payment_vendor->name }}
                                                        </div>
                                                        <div class="text-muted">
                                                            <span class="text-reset fst-italic">
                                                                {{ __('Number used: :number', ['number' => 1]) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $payment_vendor->account_number }}
                                            </td>
                                            <td>
                                                {{ $payment_vendor->description ?? '-' }}
                                            </td>
                                            <td class="text-end">
                                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#edit-payment-vendor-modal"
                                                    wire:click="$dispatch('refresh_edit_form',{id:{{ $payment_vendor->id }}})"
                                                    aria-label="{{ __('Edit :edit', ['edit' => __('Payment Vendor')]) }}">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger"
                                                    wire:click="delete_item({{ $payment_vendor->id }})">
                                                    {{ __('Delete') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan=5>
                                                {{ __('No data found.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-center align-items-center">
                            {{ $payment_vendors->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

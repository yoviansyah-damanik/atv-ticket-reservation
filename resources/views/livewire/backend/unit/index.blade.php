<div>
    {{-- Page header  --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    {{-- Page pre-title  --}}
                    <h2 class="page-title">
                        {{ __('Unit') }}
                    </h2>
                </div>
                {{-- Page title actions  --}}
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            wire:click="$dispatch('refresh_create_form')" data-bs-target="#create-unit-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            {{ __('Create :create', ['create' => __('Unit')]) }}
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#create-unit-modal" wire:click="$dispatch('refresh_create_form')"
                            aria-label="{{ __('Create :create', ['create' => __('Unit')]) }}">
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
                            <h3 class="card-title">{{ __(':data Data', ['data' => __('Unit')]) }}</h3>
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
                                        <th>{{ __('Unit Name') }}</th>
                                        <th>{{ __('Register Number') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($units as $unit)
                                        <tr>
                                            <td>
                                                {{ $units->perPage() * ($units->currentPage() - 1) + $loop->iteration }}
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar me-2"
                                                        style="background-image: url({{ $unit->image_path }}); --tblr-avatar-size:6rem"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium"> {{ $unit->name }}
                                                        </div>
                                                        <div class="text-muted">
                                                            <span class="text-reset fst-italic">
                                                                {{ __('Number used: :number', ['number' => $unit->unit_usages->count()]) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $unit->register_number }}
                                            </td>
                                            <td>
                                                @if ($unit->status == 'ready')
                                                    <span class="badge bg-green-lt">{{ __('Ready') }}</span>
                                                @elseif ($unit->status == 'used')
                                                    <span class="badge bg-cyan-lt">{{ __('Used') }}</span>
                                                @elseif ($unit->status == 'in_repair')
                                                    <span class="badge bg-yellow-lt">{{ __('In Repair') }}</span>
                                                @else
                                                    <span class="badge bg-red-lt">{{ __('Expired') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $unit->description ?? '-' }}
                                            </td>
                                            <td class="text-end">
                                                <a href="#" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                    data-bs-target="#edit-unit-modal"
                                                    wire:click="$dispatch('refresh_edit_form',{id:{{ $unit->id }}})"
                                                    aria-label="{{ __('Edit :edit', ['edit' => __('Unit')]) }}">
                                                    {{ __('Edit') }}
                                                </a>
                                                <a href="#" class="btn btn-sm btn-danger"
                                                    wire:click="delete_item({{ $unit->id }})">
                                                    {{ __('Delete') }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan=6>
                                                {{ __('No data found.') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-center align-items-center">
                            {{ $units->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

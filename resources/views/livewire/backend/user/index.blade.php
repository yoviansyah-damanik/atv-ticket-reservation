<div>
    {{-- Page header  --}}
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    {{-- Page pre-title  --}}
                    <h2 class="page-title">
                        {{ __('User') }}
                    </h2>
                </div>
                {{-- Page title actions  --}}
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <button class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            wire:click="$dispatch('refresh_create_form')" data-bs-target="#create-user-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            {{ __('Create :create', ['create' => __('User')]) }}
                        </button>
                        <button class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#create-user-modal" wire:click="$dispatch('refresh_create_form')"
                            aria-label="{{ __('Create :create', ['create' => __('User')]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </button>
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
                            <h3 class="card-title">{{ __(':data Data', ['data' => __('User')]) }}</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted">
                                    {{ __('Show') }}
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            wire:model.lazy="show" size="3" wire:change='set_reset_page'>
                                    </div>
                                    {{ __('entries') }}
                                </div>
                                <div class="text-center">
                                    <button class="btn btn-primary" @if ($with_trashed === false) disabled @endif
                                        wire:click='set_trashed(false)'>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-archive" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path
                                                d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z">
                                            </path>
                                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-10"></path>
                                            <path d="M10 12l4 0"></path>
                                        </svg>
                                        {{ __('All') }}
                                    </button>
                                    <button class="btn btn-primary" @if ($with_trashed === true) disabled @endif
                                        wire:click='set_trashed(true)'>
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-archive-off" width="24"
                                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                            <path d="M8 4h11a2 2 0 1 1 0 4h-7m-4 0h-3a2 2 0 0 1 -.826 -3.822"></path>
                                            <path d="M5 8v10a2 2 0 0 0 2 2h10a2 2 0 0 0 1.824 -1.18m.176 -3.82v-7">
                                            </path>
                                            <path d="M10 12h2"></path>
                                            <path d="M3 3l18 18"></path>
                                        </svg>
                                        {{ __('Trashed') }}
                                    </button>
                                </div>
                                <div class="text-muted">
                                    {{ __('Search:') }}
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            aria-label="Search" wire:model.live="search"
                                            wire:change='set_reset_page'>
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
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td>
                                                {{ $users->perPage() * ($users->currentPage() - 1) + $loop->iteration }}
                                            </td>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar me-2"
                                                        style="background-image: url({{ $user->image_path }}); --tblr-avatar-size:6rem"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium"> {{ $user->name }}
                                                        </div>
                                                        <div class="text-muted">
                                                            <span class="text-reset fst-italic">
                                                                {{ $user->username }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $user->email }}
                                            </td>
                                            <td>
                                                @if ($user->role_name == 'User')
                                                    <span class="badge bg-green-lt">{{ $user->role_name }}</span>
                                                @elseif ($user->role_name == 'Administrator')
                                                    <span class="badge bg-cyan-lt">{{ $user->role_name }}</span>
                                                @elseif ($user->role_name == 'Owner')
                                                    <span class="badge bg-yellow-lt">{{ $user->role_name }}</span>
                                                @elseif ($user->role_name == 'Finance')
                                                    <span class="badge bg-purple-lt">{{ $user->role_name }}</span>
                                                @else
                                                    <span class="badge bg-red-lt">{{ $user->role_name }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->status == 'active')
                                                    <span class="badge bg-green-lt">{{ __('Active') }}</span>
                                                @else
                                                    <span class="badge bg-red-lt">{{ __('Blocked') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if (!$user->trashed())
                                                    @if ($user->role_name != 'Administrator')
                                                        @if ($user->status == 'active')
                                                            <button class="btn btn-sm btn-dark"
                                                                wire:click="set_active_status({{ $user->id }})">
                                                                {{ __('Block') }}
                                                            </button>
                                                        @else
                                                            <button class="btn btn-sm btn-primary"
                                                                wire:click="set_active_status({{ $user->id }})">
                                                                {{ __('Activate') }}
                                                            </button>
                                                        @endif
                                                    @endif
                                                    @if (!in_array($user->role_name, ['User', 'Administrator']))
                                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#edit-user-modal"
                                                            wire:click="$dispatch('refresh_edit_form',{id:{{ $user->id }}})"
                                                            aria-label="{{ __('Edit :edit', ['edit' => __('User')]) }}">
                                                            {{ __('Edit') }}
                                                        </button>
                                                    @endif
                                                    @if ($user->role_name != 'Administrator')
                                                        <button class="btn btn-sm btn-danger"
                                                            wire:click="delete_item({{ $user->id }})">
                                                            {{ __('Delete') }}
                                                        </button>
                                                    @endif
                                                @else
                                                    <button class="btn btn-sm btn-info"
                                                        wire:click="restore_item({{ $user->id }})">
                                                        {{ __('Restore') }}
                                                    </button>
                                                    <button class="btn btn-sm btn-danger"
                                                        wire:click="force_delete_item({{ $user->id }})">
                                                        {{ __('Force Delete') }}
                                                    </button>
                                                @endif
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
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

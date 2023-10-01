<div class="container-fluid bg-white sticky-top">
    <div class="container">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-2 py-lg-0">
            <a href="{{ route('home') }}" class="navbar-brand order-1 order-lg-0">
                <img class="img-fluid" src="{{ asset('branding-assets/img/logo.png') }}" alt="Logo">
            </a>
            <button type="button" class="navbar-toggler ms-auto me-0 order-0 order-lg-1" data-bs-toggle="collapse"
                data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="ps-lg-4 order-2">
                @if (Auth::check() && Auth::user()->roleName == 'Administrator')
                    <a href="{{ route('dashboard.home') }}"
                        class="btn btn-danger btn-book text-uppercase px-4 py-2 me-2">
                        <span class="d-none d-lg-block">
                            {{ __('Dashboard') }}
                        </span>
                        <span class="d-block d-lg-none">
                            <i class="bi bi-fire"></i>
                        </span>
                    </a>
                @else
                    <a href="{{ route('reservation') }}" class="btn btn-danger btn-book text-uppercase px-4 py-2 me-2">
                        <span class="d-none d-lg-block">
                            {{ __('Book Now') }}
                        </span>
                        <span class="d-block d-lg-none">
                            <i class="bi bi-journal-arrow-up"></i>
                        </span>
                    </a>
                @endif

                @auth
                    <div class="dropdown d-inline-block dropdown-account">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-expanded="false">
                            <img class="rounded-circle" style="width:40px; aspect-ratio:1/1"
                                src="{{ Auth::user()->image_path }}" alt="Avatar">
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">
                                    Hai, {{ Auth::user()->name }}!
                                </h6>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            @if (Auth::user()->isUser)
                                <li>
                                    <a class="dropdown-item" href="{{ route('account.history') }}">
                                        <i class="bi bi-journal-bookmark"></i>
                                        <span class="small">
                                            <span
                                                class="badge bg-success">{{ Auth::user()->reservations()->completedStatus()->count() }}</span>
                                            <span
                                                class="badge bg-warning">{{ Auth::user()->reservations()->waitingStatus()->count() }}</span>
                                            <span
                                                class="badge bg-info">{{ Auth::user()->reservations()->readyStatus()->count() }}</span>
                                            <span
                                                class="badge bg-danger">{{ Auth::user()->reservations()->canceledStatus()->count() }}</span>
                                        </span>
                                        {{ __('History') }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('account') }}">
                                        <i class="bi bi-arrow-up-right-square"></i>
                                        {{ __('Setting') }}
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard.home') }}">
                                        <i class="bi bi-arrow-up-right-square"></i>
                                        {{ __('Dashboard') }}
                                    </a>
                                </li>
                            @endif
                            <li>
                                <form action="{{ route('logout') }}" method="post">
                                    @csrf
                                    <button class="dropdown-item">
                                        <i class="bi bi-box-arrow-left"></i>
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-primary text-uppercase px-4 py-2" href="{{ route('register') }}">
                        <span class="d-none d-lg-inline">
                            {{ __('Register') }}
                        </span>
                        <span class="d-inline d-lg-none">
                            <i class="bi bi-box-arrow-in-right"></i>
                        </span>
                    </a>
                @endauth
            </div>
            <div class="collapse navbar-collapse order-3 order-lg-1" id="navbarCollapse">
                <div class="navbar-nav ms-auto">
                    <a href="{{ route('home') }}#" class="nav-item nav-link">{{ __('Home') }}</a>
                    <a href="{{ route('home') }}#about-us" class="nav-item nav-link">{{ __('About Us') }}</a>
                    <a href="{{ route('home') }}#unit" class="nav-item nav-link">{{ __('Unit') }}</a>
                    <a href="{{ route('home') }}#package" class="nav-item nav-link">{{ __('Package') }}</a>
                    <a href="{{ route('home') }}#testimonial" class="nav-item nav-link">{{ __('Testimonial') }}</a>
                    <a href="{{ route('home') }}#contact-us" class="nav-item nav-link">{{ __('Contact Us') }}</a>
                    {{-- <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle"
                            data-bs-toggle="dropdown">{{ $item['title'] }}</a>
                        <div class="dropdown-menu bg-light rounded-0 m-0">
                            @foreach ($item['children'] as $child)
                                <a href="{{ $child['uri'] }}" class="dropdown-item">{{ $child['title'] }}</a>
                            @endforeach
                        </div>
                    </div> --}}
                </div>
            </div>
        </nav>
    </div>
</div>

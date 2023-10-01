@extends('frontend.layouts.app')

@section('content')
    {{-- Hero Start --}}
    <div class="container-fluid px-0 mb-5">
        <div id="header-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('frontend-assets/img/carousel-1.png') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 text-center">
                                    <p class="fs-4 text-white animated zoomIn">
                                        {{ __('Welcome to') }} <strong class="text-primary">
                                            {{ config('app.name') }}</strong></p>
                                    <h1 class="display-3 text-primary mb-4 animated zoomIn">
                                        {{ __('The First ATV Rental in Padangsidimpuan City') }}
                                    </h1>
                                    <a href="{{ route('reservation') }}"
                                        class="btn btn-light rounded-pill py-3 px-5 animated zoomIn">
                                        {{ __('Book Now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ asset('frontend-assets/img/carousel-2.png') }}" alt="Image">
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-7 text-center">
                                    <p class="fs-4 text-white animated zoomIn">
                                        {{ __('Welcome to') }} <strong class="text-primary">
                                            {{ config('app.name') }}</strong></p>
                                    </p>
                                    <h1 class="display-3 text-primary mb-4 animated zoomIn">
                                        {{ __('The best choice for your family recreation.') }}
                                    </h1>
                                    <a href="{{ route('reservation') }}"
                                        class="btn btn-light rounded-pill py-3 px-5 animated zoomIn">
                                        {{ __('Book Now') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    {{-- Hero End --}}

    {{-- About Start --}}
    <div class="container-xxl py-5" id="about-us">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6 text-end">
                            <img class="img-fluid bg-white w-100 mb-3 wow fadeIn" data-wow-delay="0.1s"
                                src="{{ asset('frontend-assets/img/about-1.jpg') }}" alt="">
                            <img class="img-fluid bg-white w-100 wow fadeIn" data-wow-delay="0.2s"
                                src="{{ asset('frontend-assets/img/about-2.png') }}" alt="">
                        </div>
                        <div class="col-6">
                            <img class="img-fluid bg-white w-100 mb-3 wow fadeIn" data-wow-delay="0.3s"
                                src="{{ asset('frontend-assets/img/about-3.jpg') }}" alt="">
                            <img class="img-fluid bg-white w-100 wow fadeIn" data-wow-delay="0.4s"
                                src="{{ asset('frontend-assets/img/about-4.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="section-title">
                        <p class="fs-5 fw-medium fst-italic text-primary">{{ __('About Us') }}</p>
                        <h1 class="display-6">
                            {{ __('The First ATV Rental in Padangsidimpuan City') }}
                        </h1>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-4">
                            <img class="img-fluid bg-white w-100" src="{{ asset('frontend-assets/img/about-5.jpg') }}"
                                alt="">
                        </div>
                        <div class="col-sm-8">
                            <h5>{{ __('Easily accessible location') }}</h5>
                            <p class="mb-0">
                                {{ __('Access to the location is easy and the parking area is quite large.') }}
                            </p>
                        </div>
                    </div>
                    <div class="border-top mb-4"></div>
                    <div class="row g-3">
                        <div class="col-sm-8">
                            <h5>{{ __('The route is safe, comfortable, and family friendly') }}</h5>
                            <p class="mb-0">
                                {{ __('The route you will take has been surveyed beforehand so that you can take the route safely and comfortably.') }}
                            </p>
                        </div>
                        <div class="col-sm-4">
                            <img class="img-fluid bg-white w-100" src="{{ asset('frontend-assets/img/about-6.jpg') }}"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- About End --}}

    {{-- Unit Start --}}
    <div class="container-fluid product py-5 my-5" id="unit">
        <div class="container py-5">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary">{{ __('Our Unit') }}</p>
                <h1 class="display-6">
                    {{ __('Units that you can use for adventure.') }}
                </h1>
            </div>
            <div class="owl-carousel unit-carousel wow fadeInUp" data-wow-delay="0.5s">
                @foreach ($units as $unit)
                    <span class="d-block product-item rounded">
                        <div class="d-flex justify-content-center align-items-center"
                            style="max-height: 300px; overflow:hidden;">
                            <img src="{{ $unit->image_path }}" alt="Unit Image">
                        </div>
                        <div class="bg-white shadow-sm text-center p-4 position-relative mt-n5 mx-4">
                            <h4 class="text-primary">{{ $unit->name }}</h4>
                            <span class="text-body">
                                {{ $unit->description ?? __('No description embedded.') }}
                            </span>
                        </div>
                    </span>
                @endforeach
            </div>
        </div>
    </div>
    {{-- Unit End --}}

    {{-- Package Start --}}
    <div class="container-xxl py-5" id="package">
        <div class="container">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary">
                    {{ __('Package') }}
                </p>
                <h1 class="display-6">{{ __('The packages we offer for you.') }}</h1>
            </div>
            <div class="row g-4">
                @foreach ($packages as $package)
                    <div class="col-lg-4 col-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($loop->iteration - 1) * 0.2 }}s">
                        <div class="store-item position-relative text-center">
                            <img class="img-fluid" src="{{ $package->image_path }}" alt="">
                            <div class="p-4">
                                <div class="text-center mb-3">
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                    <small class="fa fa-star text-primary"></small>
                                </div>
                                <h4 class="mb-3">{{ $package->title }}</h4>
                                <p>{{ $package->description ?? __('No description embedded.') }}</p>
                                <h4 class="text-primary">{{ PriceHelper::idr($package->price, 0, true) }}</h4>
                            </div>
                            <div class="store-overlay">
                                <a href="{{ route('reservation') }}" class="btn btn-primary rounded-pill py-2 px-4 m-2">
                                    {{ __('Book Now') }}
                                    <i class="fa fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    {{-- Package End --}}

    {{-- Testimonial Start --}}
    <div class="container-fluid testimonial py-5 my-5" id="testimonial">
        <div class="container py-5">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-white">{{ __('Testimonial') }}</p>
                <h1 class="display-6">{{ __('What our clients say about our services') }}</h1>
            </div>
            <div class="owl-carousel testimonial-carousel wow fadeInUp" data-wow-delay="0.5s">
                <div class="testimonial-item p-4 p-lg-5">
                    <p class="mb-4">
                        Kapan lagi bisa menikmati mengendarai ATV di Kota Padangsidimpuan? Layanannya jooosss!!!
                    </p>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="img-fluid flex-shrink-0" src="{{ asset('frontend-assets/img/testimonial-1.jpg') }}"
                            alt="">
                        <div class="text-start ms-3">
                            <h5>Butet Hasibuan</h5>
                            <span class="text-primary">Mahasiswi</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item p-4 p-lg-5">
                    <p class="mb-4">
                        Ada pemandunya bagi kamu yang tidak bisa mengendarai ATV, pokoknya mantap deh!
                    </p>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="img-fluid flex-shrink-0" src="{{ asset('frontend-assets/img/testimonial-2.jpg') }}"
                            alt="">
                        <div class="text-start ms-3">
                            <h5>Gabe Hutabarat</h5>
                            <span class="text-primary">Wiraswasta</span>
                        </div>
                    </div>
                </div>
                <div class="testimonial-item p-4 p-lg-5">
                    <p class="mb-4">
                        Liburan bersama keluarga terasa asik mengelilingi kebun menggunakan ATV
                    </p>
                    <div class="d-flex align-items-center justify-content-center">
                        <img class="img-fluid flex-shrink-0" src="{{ asset('frontend-assets/img/testimonial-3.jpg') }}"
                            alt="">
                        <div class="text-start ms-3">
                            <h5>Kiri Kanan Nasution</h5>
                            <span class="text-primary">Dosen</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Testimonial End --}}

    {{-- Contact Start --}}
    <div class="container-xxl contact py-5" id="contact-us">
        <div class="container">
            <div class="section-title text-center mx-auto wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="fs-5 fw-medium fst-italic text-primary">{{ __('Contact Us') }}</p>
                <h1 class="display-6">{{ __('Contact us right now') }}</h1>
            </div>
            <div class="row justify-content-center wow fadeInUp" data-wow-delay="0.1s">
                <div class="col-lg-8">
                    <p class="text-center mb-5">
                        {{ __("Don't hesitate to contact us. We are ready to serve you.") }}
                    </p>
                    <div class="row g-5">
                        <div class="col-md-4 text-center wow fadeInUp" data-wow-delay="0.3s">
                            <div class="btn-square mx-auto mb-3">
                                <i class="fa fa-envelope fa-2x text-white"></i>
                            </div>
                            <p class="mb-2">
                                <a href="mailto:atvpadangsidimpuan@gmail.com">atvpadangsidimpuan@gmail.com</a>
                            </p>
                        </div>
                        <div class="col-md-4 text-center wow fadeInUp" data-wow-delay="0.4s">
                            <div class="btn-square mx-auto mb-3">
                                <i class="fa fa-phone fa-2x text-white"></i>
                            </div>
                            <p class="mb-2">
                                <a href="tel:081360097257">
                                    +62 813 6009 7257
                                </a>
                            </p>
                            <p class="mb-0">
                                <a href="tel:081370970921">
                                    +62 813 7097 0921
                                </a>
                            </p>
                        </div>
                        <div class="col-md-4 text-center wow fadeInUp" data-wow-delay="0.5s">
                            <div class="btn-square mx-auto mb-3">
                                <i class="fa fa-map-marker-alt fa-2x text-white"></i>
                            </div>
                            <p class="mb-2">Depan SMA Negeri 8 Kota Padangsidimpuan dan SMK Negeri 4 Kota
                                Padangsidimpuan, Perkebunan PTPN 3 Tangsi Tengah, Pijorkoling
                            </p>
                            <p class="mb-0">Kec. Padangsidimpuan Tenggara, Kota Padangsidimpuan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Contact Start --}}
@endsection

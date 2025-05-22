@extends('layouts.home.app')

@section('title', 'HOME')

@push('styles')
    <style>
        .section-header {
            align-items: center;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            display: flex;
            height: 90vh;
            justify-content: center;
            position: sticky;
            top: 0;
            transition: opacity .5s ease, transform .5s ease;
            width: auto;
            z-index: 1
        }

        .section-header h2 {
            border-radius: 10px;
            text-shadow: 0 10px 20px #000000;
            color: #ffffff;
            font-size: 2.5rem;
            padding: 1rem 2rem;
            width: auto
        }

        .scrolled .section-header {
            opacity: 0;
            transform: translateY(-100%)
        }

        .section-content {
            background-color: #fff;
            padding: 4rem 2rem;
            position: relative;
            z-index: 2
        }

        .shadow-img {
            border-radius: 10px;
            box-shadow: 0 10px 20px #0003
        }

        .shadow-img:hover {
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(155, 89, 182, 0.9)
        }

        .section-subheading {
            border-left: 5px solid #9b59b6;
            color: #333;
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-left: 1rem
        }

        .section-content .row,
        .section-content .col-md-6,
        .carousel-inner,
        .shadow-img {
            max-width: 100%;
            overflow-x: hidden
        }

        .carousel-control-prev-icon::after,
        .carousel-control-next-icon::after {
            background-color: #1b2416;
            content: '';
            display: inline-block;
            height: 100%;
            mask-repeat: no-repeat;
            mask-size: cover;
            width: 100%
        }

        .carousel-control-prev-icon::after {
            mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L6.707 7l4.647 4.646a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708 0z'/%3E%3C/svg%3E")
        }

        .carousel-control-next-icon::after {
            mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M4.646 1.646a.5.5 0 0 0 0 .708L9.293 7l-4.647 4.646a.5.5 0 0 0 .708.708l5-5a.5.5 0 0 0 0-.708l-5-5a.5.5 0 0 0-.708 0z'/%3E%3C/svg%3E")
        }
    </style>
@endpush

@section('content')
    <!-- Intro -->
    <div class="starter_container bg-dark text-white text-center py-5">
        <h2 class="display-4 fw-bold">Berr DECOR</h2>
        <h4>"Best in the city"</h4>
        <hr class="border-danger border-2 opacity-100 mx-auto w-25">
    </div>

    <!-- VASES -->
    <section class="section-with-header" id="vases">
        <div class="section-header d-flex align-items-center justify-content-center text-white"
            style="background-image: url('{{ asset('/public/images/img/vase_bg.webp') }}');">
            <h2 class="display-5 fw-bold">Explore Luxury Vases</h2>
        </div>

        <div class="section-content">
            <div class="row align-items-center gx-4 gy-4">
                <div class="col-md-6">
                    <div data-aos="fade-right">
                        {{-- <img src="{{ asset('/public/images/icons/vase.webp') }}" alt="Vase Icon" class="mb-3"
                            width="50">
                        --}}
                        <h3 class="section-subheading">Elegance in Every Detail</h3>
                        <p class="fs-5">
                            Infuse your luxury house with timeless sophistication through our exquisite selection of luxury
                            vases.
                            Meticulously crafted to captivate the eye, each piece exudes opulence and elegance.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-wrap gap-3 justify-content-center">
                    @foreach (['vase1.webp', 'vase2.webp', 'vase3.webp', 'vase4.webp'] as $img)
                        <img src="{{ asset("/public/images/img/$img") }}" class="shadow-img" width="220" height="200">
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- CANDLES -->
    <section class="section-with-header" id="candles">
        <div class="section-header d-flex align-items-center justify-content-center text-white"
            style="background-image: url('{{ asset('/public/images/img/candle1.webp') }}');">
            <h2 class="display-5 fw-bold">Indulge Your Senses with Fragrances</h2>
        </div>

        <div class="section-content">
            <div class="row align-items-center gx-4 gy-4">
                <div class="col-md-6 d-flex flex-wrap gap-3 justify-content-center">
                    @foreach (['candle1.webp', 'candle2.webp', 'candle3.webp', 'candle1.webp'] as $img)
                        <img src="{{ asset("/public/images/img/$img") }}" class="shadow-img" width="220" height="200">
                    @endforeach
                </div>
                <div class="col-md-6">
                    <div data-aos="fade-left">
                        {{-- <img src="{{ asset('/public/images/icons/vase.webp') }}" alt="Icon" class="mb-3" width="50">
                        --}}
                        <h3 class="section-subheading">Elegance in Every Detail</h3>
                        <p class="fs-5">
                            Pamper your senses with our luxurious scented candles, meticulously designed to elevate your
                            upscale
                            home ambiance.
                            Let the fragrances infuse your surroundings with warmth and tranquility.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FLOWERS -->
    <section class="section-with-header" id="flowers">
        <div class="section-header d-flex align-items-center justify-content-center text-white"
            style="background-image: url('{{ asset('/public/images/img/flower_bg.webp') }}');">
            <h2 class="display-5 fw-bold">Timeless Floral Elegance</h2>
        </div>

        <div class="section-content">
            <div class="row align-items-center gx-4 gy-4">
                <div class="col-md-6">
                    <div data-aos="fade-right">
                        <h3 class="section-subheading">Elegance in Every Detail</h3>

                        <p class="fs-5">
                            Experience the eternal allure of blooming floral charm with our exquisite collection.
                            Elevate your surroundings and immerse yourself in timeless beauty that continues to captivate
                            and
                            inspire.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 d-flex flex-wrap justify-content-center gap-3">
                    @foreach (['flower1.webp', 'flower2.webp', 'flower1.webp', 'flower2.webp'] as $img)
                        <img src="{{ asset("/public/images/img/$img") }}" class="shadow-img" width="220" height="200">
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- WALL ART -->
    <section class="section-with-header" id="wall-art">
        <div class="section-header d-flex align-items-center justify-content-center text-white"
            style="background-image: url('{{ asset('/public/images/img/wall_art_bg.webp') }}');">
            <h2 class="display-5 fw-bold">Luxurious Stylish Wall Décor</h2>
        </div>

        <div class="section-content">
            <div class="row align-items-center gx-4 gy-4">
                <div class="col-md-6">
                    <div id="wallDecorCarousel" class="carousel slide shadow rounded" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach (['slider1.webp', 'slider2.webp', 'slider3.webp'] as $index => $img)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ asset("/public/images/img/$img") }}" class="d-block w-100"
                                        alt="Decor {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#wallDecorCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#wallDecorCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div data-aos="fade-left">
                        <h3 class="section-subheading">Elegance in Every Detail</h3>

                        <p class="fs-5">
                            Each piece is handmade at the crack of dawn, using only the simplest of materials to bring out
                            artistry that transforms your space.
                            Experience the blend of simplicity and beauty through our curated wall décor collection.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        window.addEventListener('scroll', () => {
            document.querySelectorAll('.section-with-header').forEach(section => {
                const header = section.querySelector('.section-header');
                const rect = section.getBoundingClientRect();
                if (rect.top < -100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
            });
        });
    </script>
@endpush
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-uppercase" href="{{ route('home') }}">
            <img src="{{asset('/public/images/icons/icon-2.webp')}}" width="26" height="26" />
            Berr
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-lg-2" id="navbar-links">
                <li class="nav-item"><a class="nav-link" href="#vases">Vases</a></li>
                <li class="nav-item"><a class="nav-link" href="#candles">Candles</a></li>
                <li class="nav-item"><a class="nav-link" href="#flowers">Flowers</a></li>
                <li class="nav-item"><a class="nav-link" href="#wall-art">Wall Arts</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('shop.view') }}">Shop</a></li>
                <li class="nav-item">
                    <a class="nav-link px-2" href="{{ auth()->check() ? route('dashboard') : route('login') }}">
                        <img src="{{ auth()->check()
    ? asset('/public/images/icons/white-person.webp')
    : asset('/public/images/icons/white-add-user.webp') }}" alt="profile" width="22" height="22">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
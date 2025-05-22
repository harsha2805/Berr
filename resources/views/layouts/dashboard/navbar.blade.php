<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-1">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand fw-semibold fs-4 m-0" href="{{ route('home') }}"
            style="font-family: 'Baloo 2', cursive;">
            Berr
        </a>

        <!-- Toggler for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav items (icons only) -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarNavDropdown">
            <ul class="navbar-nav align-items-center gap-3">
                <!-- Cart icon -->
                <li class="nav-item">
                    <a href="{{ route('cart.index') }}" class="nav-link text-white p-0" title="Cart"
                        data-bs-toggle="tooltip">
                        <i class="bi bi-cart2 fs-5"></i>
                    </a>
                </li>

                <!-- Home icon -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link text-white p-0" title="Home" data-bs-toggle="tooltip">
                        <i class="bi bi-house-door fs-5"></i>
                    </a>
                </li>

                <!-- Logout icon -->
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link text-white p-0" title="Sign Out"
                            data-bs-toggle="tooltip">
                            <i class="bi bi-box-arrow-right fs-5"></i>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
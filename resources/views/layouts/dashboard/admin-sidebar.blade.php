<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-1">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : 'text-dark' }}">
                    <i class="bi bi-person-fill me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.categories.view') }}"
                    class="nav-link {{ request()->routeIs('admin.categories.view') ? 'active fw-bold' : 'text-dark' }}">
                    <i class="bi bi-tags me-2"></i> Categories
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('admin.products.view') }}"
                    class="nav-link {{ request()->routeIs('admin.products.view') ? 'active fw-bold' : 'text-dark' }}">
                    <i class="bi bi-box-seam me-2"></i> Products
                </a>
            </li>
        </ul>
    </div>
</nav>
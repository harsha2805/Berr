<nav id="sidebar" class="d-flex flex-column text-white sidebar-collapsed">
    <button id="toggleSidebar" aria-label="Toggle Sidebar" title="Toggle Sidebar"
        class="d-flex align-items-center gap-2 px-3 py-2">
        <i class="fas fa-bars"></i>
    </button>
    <ul class="nav flex-column">
        @foreach($categories as $category)
            <li class="nav-item" role="none">
                <a href="#{{ $category->slug }}" class="nav-link d-flex align-items-center" role="menuitem" tabindex="0">
                    @if($category->icon_class)
                        <i class="{{ $category->icon_class }}"></i>
                    @elseif($category->image_path)
                        <img data-light="{{ asset($category->dark_image_path ?? $category->image_path) }}"
                            data-dark="{{ asset($category->image_path) }}" class="category-icon" loading="lazy"
                            alt="{{ $category->name }}" />
                    @endif
                    <span class="sidebar-label ms-2">{{ $category->name }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <div class="p-3 border-top mt-auto d-flex justify-content-center position-relative">
        <a href="{{ route('cart.index') }}" class="text-white position-relative" style="font-size: 1.5rem;">
            <i class="bi bi-cart3"></i>
            <span id="cart-count"
                class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ count(session('cart', [])) }}
            </span>
        </a>
    </div>
</nav>
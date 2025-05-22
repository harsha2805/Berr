{{-- resources/views/layouts/shop.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'BERR | Decor Store')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('public/css/shop/index.css') }}">
    <link rel="icon" href="{{ asset('public/images/icons/icon-2.webp') }}" type="image/x-icon">
</head>

<body>
    <div class="app-container">
        {{-- Sidebar --}}
        @include('layouts.shop.sidebar')

        {{-- Main Content --}}
        <main class="py-4">
            @yield('content')
        </main>

        {{-- Floating Buttons --}}
        <div id="floating-theme-wrapper">
            <button id="themeToggleBtn" title="Toggle Theme" aria-label="Toggle Theme">
                <i class="bi bi-moon-stars-fill"></i>
            </button>
            <span class="ripple"></span>
        </div>
        <div id="floating-home-wrapper">
            <a href="{{ route('home') }}" id="floating-home-btn" title="Home" aria-label="Home">
                <i class="bi bi-house-door-fill"></i>
            </a>
            <span class="ripple"></span>
        </div>
    </div>
    <div id="app" data-login-url="{{ route('login') }}"></div>

    {{-- Scripts --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.1/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('public/js/sweet-alert-function.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const root = document.documentElement;
            const sidebar = document.getElementById('sidebar');
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const sidebarToggleBtn = document.getElementById('toggleSidebar');
            const homeRipple = document.querySelector('#floating-home-wrapper .ripple');
            const themeRipple = document.querySelector('#floating-theme-wrapper .ripple');

            // Sidebar toggle
            sidebarToggleBtn?.addEventListener('click', () => {
                sidebar.classList.toggle('sidebar-expanded');
                document.body.classList.toggle('sidebar-opened');
            });

            // Smooth scroll
            document.querySelectorAll('#sidebar .nav-link').forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const target = document.querySelector(link.getAttribute('href'));
                    if (target) {
                        window.scrollTo({ top: target.offsetTop - 60, behavior: 'smooth' });
                    }
                });
            });

            // Theme initialization
            const initialTheme = localStorage.getItem('theme') || 'light';
            setTheme(initialTheme);

            themeToggleBtn?.addEventListener('click', () => {
                const newTheme = root.classList.toggle('dark') ? 'dark' : 'light';
                localStorage.setItem('theme', newTheme);
                setTheme(newTheme);
                animateRipple(themeRipple);
            });

            animateRipple(homeRipple);

            function setTheme(theme) {
                root.classList.toggle('dark', theme === 'dark');
                updateCartIconColor(theme);
                swapCategoryImages(theme);
                updateThemeIcon(theme);
            }

            function updateCartIconColor(theme) {
                const cartIcon = document.querySelector('.bi-cart3');
                if (cartIcon) cartIcon.style.color = theme === 'dark' ? '#fff' : '#000';
            }

            function updateThemeIcon(theme) {
                const icon = themeToggleBtn.querySelector('i');
                icon.classList.toggle('bi-moon-stars-fill', theme !== 'dark');
                icon.classList.toggle('bi-brightness-high-fill', theme === 'dark');
            }

            function swapCategoryImages(theme) {
                document.querySelectorAll('.category-icon').forEach(img => {
                    const src = theme === 'dark'
                        ? img.getAttribute('data-dark')
                        : img.getAttribute('data-light');
                    if (img.src !== src) img.src = src;
                });
            }

            function animateRipple(rippleEl) {
                if (!rippleEl) return;
                rippleEl.classList.add('ripple-animate');
                rippleEl.addEventListener('animationend', () => {
                    rippleEl.classList.remove('ripple-animate');
                }, { once: true });
            }
        });

        // Quantity control functions
        function increment(btn) {
            const input = btn.previousElementSibling;
            if (input) input.value = parseInt(input.value || 0) + 1;
        }

        function decrement(btn) {
            const input = btn.nextElementSibling;
            if (input) input.value = Math.max(1, parseInt(input.value || 1) - 1);
        }
    </script>
    @stack('scripts')

</body>

</html>
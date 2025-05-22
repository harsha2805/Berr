@extends('layouts.shop.app')
@php
                            // window.location.href = '{{ route("cart.checkout") }}';
@endphp

@section('content')
    <div class="container">
        @foreach($groupedProducts as $categorySlug => $group)
            <section id="{{ $categorySlug }}" class="mb-5">
                <h2 class="fw-bold mb-4">{{ $group['name'] }}</h2>
                <div class="row g-4">
                    @foreach($group['products'] as $product)
                        <div class="col-md-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset($product->image_path) }}" class="card-img-top" alt="{{ $product->name }}">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div>
                                        <h5 class="card-title themed-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ $product->description }}</p>
                                        <div class="price">&#8377;{{ number_format($product->price, 2) }}</div>
                                    </div>
                                    <div class="card-controls mt-3 d-flex justify-content-between gap-2">
                                        <button class="btn btn-sm btn-outline-primary w-100 add-to-cart-btn"
                                            data-product-id="{{ $product->id }}">
                                            <i class="bi bi-cart-plus"></i> Add to Cart
                                        </button>
                                        <button class="btn btn-sm btn-primary w-100 buy-now-btn"
                                            data-product-id="{{ $product->id }}">
                                            <i class="bi bi-bag-check"></i> Buy Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>
@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Global click listener for Add to Cart
        document.body.addEventListener('click', function (e) {
            if (e.target.closest('.add-to-cart-btn')) {
                const button = e.target.closest('.add-to-cart-btn');
                const productId = button.getAttribute('data-product-id');

                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            updateCartCount(response.cartCount);
                            button.innerHTML = '<i class="bi bi-cart-check-fill"></i> Added';
                            button.classList.remove('btn-outline-primary');
                            button.classList.add('btn-success');
                        }
                    },
                    error: function () {
                        showErrorWithLogin("You must be logged in to add items to your cart.");
                    }
                });
            }

            // Global click listener for Buy Now
            if (e.target.closest('.buy-now-btn')) {
                const button = e.target.closest('.buy-now-btn');
                const productId = button.getAttribute('data-product-id');

                $.ajax({
                    url: '{{ route("cart.add") }}',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        quantity: 1,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        if (response.success) {
                            window.location.href = '{{ route("cart.index") }}';
                        }
                    },
                    error: function () {
                        showErrorWithLogin("You must be logged in to purchase.");
                    }
                });
            }
        });

        // Optional: Global quantity increment/decrement
        document.body.addEventListener('click', function (e) {
            if (e.target.classList.contains('quantity-increment')) {
                const input = e.target.closest('.quantity-wrapper')?.querySelector('input');
                if (input) input.value = parseInt(input.value || 0) + 1;
            }

            if (e.target.classList.contains('quantity-decrement')) {
                const input = e.target.closest('.quantity-wrapper')?.querySelector('input');
                if (input) input.value = Math.max(1, parseInt(input.value || 1) - 1);
            }
        });

        function updateCartCount(newCount) {
            const badge = document.getElementById('cart-count');
            if (badge) {
                badge.textContent = newCount;
            }
        }
    });
</script>
@endpush

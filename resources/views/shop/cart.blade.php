@extends('layouts.shop.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 fw-bold">Your Cart</h2>

        <div class="table-responsive">
            <table id="cart-table" class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th style="width:120px;">Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            const table = $('#cart-table').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{{ route("cart.data") }}',
                columns: [
                    { data: 'product', name: 'product', orderable: false, searchable: false },
                    { data: 'price', name: 'product.price', searchable: false },
                    { data: 'quantity', name: 'quantity', orderable: false, searchable: false },
                    { data: 'total', name: 'total', searchable: false, orderable: false }
                ]
            });

            let coolDownMap = new Map();

            $('#cart-table').on('click', '.btn-increment, .btn-decrement', async function () {
                const button = $(this);
                const buttonId = button.data('id') + '-' + (button.hasClass('btn-increment') ? 'inc' : 'dec');

                // CoolDown check
                if (coolDownMap.get(buttonId)) {
                    toastMsg('info', 'Please wait...', 'top-end');
                    return;
                }

                // Show "Adding..." toast
                toastMsg('info', 'Adding...', 'top-end');

                coolDownMap.set(buttonId, true);
                setTimeout(() => coolDownMap.delete(buttonId), 1000); // 1s CoolDown

                const row = button.closest('tr');
                const input = row.find('.quantity-input');
                const id = input.data('id');
                let quantity = parseInt(input.val());

                if (button.hasClass('btn-increment')) {
                    quantity++;
                    updateQuantity(id, quantity);
                } else {
                    if (quantity === 1) {
                        const confirmed = await confirmAction("Are you sure you want to delete this?");
                        if (confirmed) {
                            removeItem(id);
                        }
                    } else {
                        quantity--;
                        updateQuantity(id, quantity);
                    }
                }
            });

            function updateQuantity(id, quantity) {
                $.ajax({
                    url: '{{ route("cart.update") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cart_item_id: id,
                        quantity: quantity
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#cart-table').DataTable().ajax.reload(null, false);
                            toastMsg('info', 'Cart updated!', 'top-end');
                        }
                    }
                });
            }

            function removeItem(id) {
                $.ajax({
                    url: '{{ url("cart/remove") }}/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (res) {
                        if (res.success) table.ajax.reload(null, false);
                        toastMsg('info', 'Deleted!', 'top-end');
                    }
                });
            }
        });

        // going back to shop page
        document.querySelectorAll('#sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href.startsWith('#')) {
                    // Check if on homepage (simple check)
                    if (window.location.pathname !== '{{ route("shop.view", [], false) }}') {
                        e.preventDefault();
                        window.location.href = '{{ route("shop.view") }}' + href;
                    } else {
                        e.preventDefault();
                        const target = document.querySelector(href);
                        if (target) {
                            window.scrollTo({
                                top: target.offsetTop - 60,
                                behavior: 'smooth'
                            });
                        }
                    }
                }
            });
        });
    </script>
@endpush
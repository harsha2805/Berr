@extends('layouts.dashboard.app')

@section('title', 'PRODUCTS')

@section('content')
    <a href="{{ route('admin.products.create') }}" class="text-success mb-3" title="Add Product" style="font-size: 1rem;">
        <i class="bi bi-plus-lg me-1">Add Product</i>
    </a>

    <table id="productsTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Category</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#productsTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{{ route('admin.products.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'category', name: 'category.name' },
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    { data: 'description', name: 'description' },
                    { data: 'price', name: 'price' },
                    { data: 'stock', name: 'stock' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        $(document).on('click', '.btn-delete', function () {
            softDeleteProduct($(this));
        });

        $(document).on('click', '.btn-restore', function () {
            restoreProduct($(this));
        });

        const softDeleteProduct = async (btn) => {
            const confirmed = await confirmAction('Are you sure you want to delete this product?');

            if (!confirmed) return;

            let url = btn.data('url');

            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: async function (response) {
                    if (response.success) {
                        $('#productsTable').DataTable().ajax.reload(null, false);
                        await showSuccess(response.message);
                    }
                },
                error: function () {
                    showError("An error occurred while deleting the product.");
                }
            });
        };

        const restoreProduct = async (btn) => {
            const confirmed = await confirmAction('Enable this product?');

            if (!confirmed) return;

            let url = btn.data('url');

            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: async function (response) {
                    if (response.success) {
                        $('#productsTable').DataTable().ajax.reload(null, false);
                        await showSuccess(response.message);
                    }
                },
                error: function () {
                    showError("An error occurred while restoring the product.");
                }
            });
        };
    </script>
@endpush
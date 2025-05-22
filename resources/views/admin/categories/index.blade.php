@extends('layouts.dashboard.app')

@section('title', 'CATEGORIES')
@section('content')
    <a href="{{ route('admin.categories.create') }}" class="text-success mb-3" title="Add Category"
        style="font-size: 1rem;">
        <i class="bi bi-plus-lg me-1">Add Category</i>
    </a>

    <table id="categoriesTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Image</th>
                <th>Icon</th>
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
            $('#categoriesTable').DataTable({
                processing: true,
                serverSide: true,
                scrollX: true,
                ajax: '{{ route('admin.categories.data') }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'slug', name: 'slug' },
                    { data: 'description', name: 'description' },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'icon', name: 'icon', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'updated_at', name: 'updated_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        $(document).on('click', '.btn-delete', function () {
            softDeleteCategory($(this));
        });

        $(document).on('click', '.btn-restore', function () {
            restoreCategory($(this));
        });

        const softDeleteCategory = async (btn) => {
            const confirmed = await confirmAction('Are you sure you want to delete this category?');

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
                        $('#categoriesTable').DataTable().ajax.reload(null, false);
                        await showSuccess("That worked!");
                    }
                },
                error: function () {
                    showError("An error occurred while deleting the category.");

                }
            });
        };

        const restoreCategory = async (btn) => {
            const confirmed = await confirmAction('Enable this category?');

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
                        $('#categoriesTable').DataTable().ajax.reload(null, false);
                        await showSuccess(response.message);
                    }
                },
                error: function () {
                    showError("An error occurred while restoring the category.");
                }
            });
        };
    </script>
@endpush
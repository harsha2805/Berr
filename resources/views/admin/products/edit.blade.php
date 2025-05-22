@extends('layouts.dashboard.app')

@section('title', 'Edit Product')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}"
                required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control-plaintext text-muted"
                value="{{ old('slug', $product->slug) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control"
                rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price (INR)</label>
            <input type="number" name="price" class="form-control" step="0.01" value="{{ old('price', $product->price) }}"
                required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>

        <div class="mb-3">
            <label for="image_path" class="form-label">Image</label>
            @if ($product->image_path)
                <div class="mb-2">
                    <img src="{{ asset($product->image_path) }}" alt="Current Image" width="100" class="img-thumbnail">
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="delete_image" id="delete_image" value="1">
                    <label class="form-check-label" for="delete_image">
                        Delete current image
                    </label>
                </div>
            @endif
            <input type="file" name="image_path" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" class="form-select">
                <option value="1" {{ old('is_active', $product->is_active) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !old('is_active', $product->is_active) ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="{{ route('admin.products.view') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
@push('scripts')
    <script>
        document.getElementById('name').addEventListener('input', function () {
            let slug = this.value.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
            document.getElementById('slug').value = slug;
        });
    </script>
@endpush
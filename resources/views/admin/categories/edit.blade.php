@extends('layouts.dashboard.app')

@section('title', 'Edit Category')

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

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}"
                required>
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control-plaintext text-muted"
                value="{{ old('slug', $category->slug) }}" readonly>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            @if ($category->image_path)
                <div class="mb-2">
                    <img src="{{ asset($category->image_path) }}" alt="Image" width="24" height="24">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="delete_image" value="1" id="delete_image">
                        <label class="form-check-label" for="delete_image">Delete Image</label>
                    </div>
                </div>
            @endif
            <input type="file" name="image_path" class="form-control" accept="image/webp">
        </div>

        <div class="mb-3">
            <label class="form-label">Dark Image</label>
            @if ($category->dark_image_path)
                <div class="mb-2">
                    <img src="{{ asset($category->dark_image_path) }}" alt="Dark Image" width="24" height="24">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="delete_dark_image" value="1"
                            id="delete_dark_image">
                        <label class="form-check-label" for="delete_dark_image">Delete Dark Image</label>
                    </div>
                </div>
            @endif
            <input type="file" name="dark_image_path" class="form-control" accept="image/webp">
        </div>

        <div class="mb-3">
            <label for="icon_class" class="form-label">Icon Class</label>
            <input type="text" name="icon_class" class="form-control"
                value="{{ old('icon_class', $category->icon_class) }}">
        </div>

        <div class="mb-3">
            <label for="dark_icon_class" class="form-label">Dark Icon Class</label>
            <input type="text" name="dark_icon_class" class="form-control"
                value="{{ old('dark_icon_class', $category->dark_icon_class) }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Category</button>
        <a href="{{ route('admin.categories.view') }}" class="btn btn-secondary">Cancel</a>
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
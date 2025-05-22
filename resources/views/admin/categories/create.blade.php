@extends('layouts.dashboard.app')

@section('title', 'Add Category')

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

    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" id="slug" name="slug" class="form-control-plaintext text-muted" readonly
                value="{{ old('slug') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image_path" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Dark Image</label>
            <input type="file" name="dark_image_path" class="form-control" accept="image/*">
        </div>

        <div class="mb-3">
            <label class="form-label">Icon Class</label>
            <input type="text" name="icon_class" class="form-control" value="{{ old('icon_class') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Dark Icon Class</label>
            <input type="text" name="dark_icon_class" class="form-control" value="{{ old('dark_icon_class') }}">
        </div>

        <button type="submit" class="btn btn-primary">Create Category</button>
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
@extends('layouts.app2')

@section('title', 'Forum Create')
@section('content')
<div class="container mt-8 p-8 bg-white rounded-lg shadow-sm">
    <h1 class="text-center mb-8">Create a New Forum</h1>
    <form action="{{ route('forum.store', ['projectId' => $projectId]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-4">
            <label for="title" class="form-label">Title</label>
            <input type="text" id="title" name="title" class="form-control" placeholder="Enter the forum title" required>
        </div>
        <div class="form-group mb-4">
            <label for="content" class="form-label">Content</label>
            <textarea id="content" name="content" class="form-control" rows="6" maxlength="500" placeholder="Enter the forum content (Max 500 characters)" required></textarea>
            <small id="charCount" class="form-text text-muted">0/500 characters</small>
        </div>
        <div class="form-group mb-4">
            <label for="category" class="form-label">Category</label>
            <select id="category" name="category" class="form-control">
                <option value="" disabled selected>Select a category</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
                <!-- Add more categories here -->
            </select>
        </div>
        <div class="form-group mb-4">
            <label for="image_urls" class="form-label">Image URL</label>
            <input type="text" id="image_urls" name="image_urls" class="form-control" placeholder="Enter the image URL (optional)">
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary mr-3">
                <i class="fas fa-pen mr-2"></i> Create Forum
            </button>
            <a href="{{ route('forum.index', ['projectId' => $projectId]) }}" class="btn btn-secondary">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript to count characters -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contentTextarea = document.getElementById('content');
        const charCount = document.getElementById('charCount');

        contentTextarea.addEventListener('input', function () {
            charCount.textContent = `${this.value.length}/500 characters`;
        });
    });
</script>
<!-- Include SweetAlert2 just before the closing </body> tag -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.addEventListener('load', () => {
        // Check for a success message in the session
        const successMessage = "{{ session('success') }}";

        if (successMessage) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: successMessage,
            });
        }
    });
</script>

@endsection
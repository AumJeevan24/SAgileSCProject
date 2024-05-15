@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 p-8 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-semibold mb-8 text-center">Create a New Forum</h1>
    <form action="{{ route('forum.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-6">
            <label for="title" class="block text-gray-700 text-lg font-semibold mb-2">Title</label>
            <input type="text" id="title" name="title" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter the forum title" required>
        </div>
        <div class="mb-6">
            <label for="content" class="block text-gray-700 text-lg font-semibold mb-2">Content</label>
            <div class="relative">
                <textarea id="content" name="content" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline h-64 resize-none" maxlength="500" placeholder="Enter the forum content (Max 500 characters)" required></textarea>
                <div class="absolute bottom-2 right-2 text-gray-500 text-sm">
                    <span id="charCount">0</span>/500 characters
                </div>
            </div>
        </div>
        <div class="mb-6">
            <label for="category" class="block text-gray-700 text-lg font-semibold mb-2">Category</label>
            <select id="category" name="category" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline">
                <option value="" disabled selected>Select a category</option>
                <option value="Category 1">Category 1</option>
                <option value="Category 2">Category 2</option>
                <option value="Category 3">Category 3</option>
                <!-- Add more categories here -->
            </select>
        </div>
        <div class="mb-6">
            <label for="image_url" class="block text-gray-700 text-lg font-semibold mb-2">Image URL</label>
            <input type="text" id="image_url" name="image_url" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter the image URL (optional)">
        </div>
        <div class="mt-8 flex justify-center space-x-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg shadow-md text-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-pen mr-2"></i> Create Forum
            </button>
            <a href="{{ route('forum.index') }}" class="text-gray-600 hover:text-gray-800 py-3 px-8 rounded-lg border border-gray-300 hover:border-gray-500 text-lg transition duration-300 ease-in-out transform hover:scale-105">
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
            charCount.textContent = this.value.length;
        });
    });
</script>

@endsection

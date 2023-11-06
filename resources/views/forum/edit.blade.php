@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 p-4 bg-white rounded-lg shadow-md">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-3xl font-semibold">
            <i class="fas fa-edit mr-2 text-blue-600"></i> Edit Forum Post
        </h1>
        <a href="{{ route('forum.view', ['id' => $forumPost->id]) }}" class="text-blue-600 hover:underline">
            <i class="fas fa-arrow-left mr-1"></i> Back to Forum
        </a>
    </div>
    
    <form action="{{ route('forum.update', $forumPost->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="updatedContent" class="block text-gray-700 text-sm font-semibold mb-2">
                <i class="fas fa-pencil-alt mr-2 text-blue-600"></i> Content
            </label>
            <textarea id="updatedContent" name="updatedContent" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:shadow-outline h-40 resize-none" maxlength="500" required>{{ $forumPost->content }}</textarea>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-full shadow-md text-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-save mr-2"></i> Save Changes
            </button>
        </div>
    </form>
    
    <form action="{{ route('forum.destroy', ['forumPost' => $forumPost]) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="mt-4 flex justify-end">
            <button type="submit" class="ml-4 text-red-600 hover:text-red-700 py-2 px-6 rounded-full border border-red-600 hover:border-red-700 text-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-trash-alt mr-2"></i> Delete
            </button>
        </div>
    </form>
    
    @error('updatedContent')
    <span class="text-red-500">{{ $message }}</span>
    @enderror
</div>

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

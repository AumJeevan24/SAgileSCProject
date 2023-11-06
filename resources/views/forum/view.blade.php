@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 p-4 bg-gray-100 rounded-lg shadow-md">
    <a href="{{ route('forum.index') }}" class="text-blue-600 hover:underline block mb-4">
        <i class="fas fa-arrow-left mr-1"></i> Back
    </a>

    <div class="mb-4 text-right">
        @if(auth()->user() && auth()->user()->id === $forumPost->user_id)
            <a href="{{ route('forum.edit', ['forumPost' => $forumPost]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-full shadow-md text-lg">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border border-gray-300">
        <h1 class="text-4xl font-semibold mb-6">{{ $forumPost->title }}</h1>
        <div class="flex items-center text-gray-600 text-sm mb-6">
            <div class="flex items-center mr-4">
                <div class="bg-blue-200 p-2 rounded-full text-white">
                    <i class="fas fa-user-circle text-xl"></i>
                </div>
                <span class="ml-2 font-semibold">{{ $forumPost->user->name }}</span>
                
            </div>
            <div class="flex items-center mr-4">
                <div class="bg-blue-200 p-2 rounded-full text-white">
                    <i class="far fa-clock text-xl"></i>
                </div>
                <span class="ml-2 font-semibold">{{ $forumPost->created_at->format('F d, Y h:i A') }}</span>
            </div>
            <div class="flex items-center">
                <div class="bg-blue-200 p-2 rounded-full text-white">
                    <i class="fas fa-tag text-xl"></i>
                </div>
                <span class="ml-2 font-semibold">{{ $forumPost->category }}</span>
            </div>
        </div>

        <div class="text-gray-700 text-lg leading-relaxed">{{ $forumPost->content }}</div>

        @if($forumPost->image_urls)
            <div class="mt-4">
                <img src="{{ $forumPost->image_urls }}" alt="Forum Image" class="w-120 h-120 object-cover rounded-lg shadow-md">
            </div>
        @endif
    </div>

    <div class="mt-8 border-t border-gray-300 pt-4">
        <div class="text-xl font-semibold mb-4">Comments</div>
        
        <form method="POST" action="{{ route('forum.favorite', ['forumId' => $forumPost->id]) }}" class="mb-4">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-full shadow-md text-lg">
                <i class="fas fa-heart mr-2"></i> Favorite
            </button>
        </form>
        
        {{-- <form method="POST" action="{{ route('forum.favorite', ['forumId' => $forumPost->id]) }}" class="mb-4">
            @csrf
            @method('DELETE') <!-- Add this line to specify DELETE method -->
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-full shadow-md text-lg">
                <i class="fas fa-heart-broken mr-2"></i> Unfavorite
            </button>
        </form> --}}

        <div class="border border-gray-300 p-4 rounded-lg shadow-md">
            <form method="POST" action="{{ route('comments.store', ['forum_id' => $forumPost->id]) }}">
                @csrf
                <textarea name="content" class="w-full p-2 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Type your comment here..." required></textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-full shadow-md text-lg">
                    <i class="fas fa-paper-plane mr-2"></i> Post Comment
                </button>
            </form>
        </div>

        
        <div class="mt-4" id="commentSection">
            @foreach($forumPost->comments as $comment)
                <div class="bg-gray-200 p-4 rounded-lg shadow-md mb-4">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-600 p-2 rounded-full text-white">
                            <i class="fas fa-user-circle text-xl"></i>
                        </div>
                        <div class="ml-2">
                            <span class="font-semibold">{{ $comment->user->name }}</span>
                            <span class="text-gray-600 ml-2">{{ $comment->created_at->format('F d, Y h:i A') }}</span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $comment->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<style>
    /* Add custom CSS styles here */
    .text-red-500 {
        color: #e53e3e; /* Red color for error text */
    }
</style>

@endsection

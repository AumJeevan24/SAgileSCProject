@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-light-blue">
    <!-- Header -->
    <header class="bg-navy-blue text-blue py-4 text-center">
        <h1 class="text-4xl font-extrabold flex items-center justify-center">
            <i class="fas fa-comments mr-2"></i> Forum
        </h1>
    </header>

    <!-- Main Content -->
    <div class="flex-grow flex">
        <!-- Left Sidebar for Create Button, Categories, and Forum Rules -->
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow-md">
            <div class="mb-4">
                <a href="{{ route('forum.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-full shadow-md text-lg block text-center transition duration-300 ease-in-out transform hover:scale-105">
                    <i class="fas fa-pen"></i> Create Forum
                </a>
            </div>

            <div class="mb-4">
                <h3 class="text-2xl font-semibold mb-2">Forum Categories</h3>
                <form action="{{ route('forum.index') }}" method="GET">
                    <select name="category" id="category" class="border rounded-md p-2 w-full">
                        <option value="">All Categories</option>
                        <option value="Category 1" {{ $selectedCategory === 'Category 1' ? 'selected' : '' }}>Category 1</option>
                        <option value="Category 2" {{ $selectedCategory === 'Category 2' ? 'selected' : '' }}>Category 2</option>
                        <option value="Category 3" {{ $selectedCategory === 'Category 3' ? 'selected' : '' }}>Category 3</option>
                        <!-- Add more categories here -->
                    </select>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-full shadow-md text-lg w-full mt-2 flex items-center justify-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                </form>
            </div>

            <!-- Forum Rules Card -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-2xl font-semibold mb-2">Forum Rules</h3>
                <ul class="list-disc pl-6">
                    <li>Be respectful and considerate of others.</li>
                    <li>No spamming or self-promotion.</li>
                    <li>Stay on-topic in discussions.</li>
                    <li>Report any inappropriate content.</li>
                </ul>
            </div>

            <!-- Additional Sidebar Content (You can add more items here) -->
            <div class="bg-blue-100 p-4 rounded-lg shadow-md mb-4">
                <h3 class="text-2xl font-semibold mb-2">Announcements</h3>
                <p class="text-gray-700">Stay updated with the latest forum announcements and news.</p>
            </div>
        </aside>
        {{-- <!-- Display Favorited Forums -->
        <div class="mb-4">
            <h3 class="text-2xl font-semibold mb-2">Favorited Forums</h3>
            <ul>
                @foreach ($favoritedForums as $forum)
                    <li>
                        <a href="{{ route('forum.view', ['id' => $forum->id]) }}" class="text-blue-600 hover:underline">
                            {{ $forum->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        </aside> --}}
        
       <!-- Right Section for Forum Threads -->
       <main class="w-3/4 pl-4 flex-grow">
        <!-- Forum Threads -->
        <div class="bg-white p-4 rounded-lg shadow-md mb-4">
            @if ($forumPosts->isEmpty())
                <div class="text-center text-gray-600 mb-6">
                    <i class="fas fa-info-circle text-2xl"></i> No forums found for "{{ $selectedCategory }}"
                </div>
            @endif

            @foreach($forumPosts as $forumPost)
                <div class="forum-card bg-blue-50 p-4 rounded-lg shadow-md mb-6 hover:shadow-lg hover:scale-105">
                    <!-- Hover effect applied to the forum card -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-semibold">{{ $forumPost->title }}</h2>
                        <a href="{{ route('forum.view', ['id' => $forumPost->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-2 rounded-full shadow-md text-sm transition duration-300 ease-in-out transform hover:scale-105">
                            <i class="fas fa-comments"></i> View Forum
                        </a>
                    </div>
                    <div class="flex items-center text-gray-600 text-sm mt-2">
                        <div class="flex items-center mr-4">
                            <i class="fas fa-user-circle text-xl mr-2"></i> {{ $forumPost->user->name }}
                        </div>
                        <div class="flex items-center mr-4">
                            <i class="far fa-clock text-xl mr-2"></i> {{ $forumPost->created_at->diffForHumans() }}
                        </div>
                        <div class="flex items-center">
                            <span class="bg-blue-200 text-blue-800 py-1 px-2 rounded-full text-xs">{{ $forumPost->category }}</span>
                        </div>
                    </div>
                    <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($forumPost->content, 150) }}</p>
                </div>
            @endforeach
        </div>

        <!-- Tailwind CSS Pagination Links -->
        <div class="mt-4 text-center space-x-2 text-xl">
            {{ $forumPosts->links('pagination::tailwind') }}
        </div>
    </main>
</div>

<!-- Footer -->
<footer class="bg-gray-900 text-white text-center py-3">
    &copy; {{ date('Y') }} Jeevan Forum. All Rights Reserved.
</footer>
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
@endsection
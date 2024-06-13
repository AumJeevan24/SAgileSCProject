@extends('layouts.app2')

@section('title', 'Forum Index')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <header class="bg-primary text-white py-4 text-center mb-4 rounded">
        <h1 class="display-4 font-weight-bold">
            <i class="fas fa-comments mr-2"></i> Forum
        </h1>
    </header>

    <!-- Main Content -->
    <div class="row">
        <!-- Left Sidebar for Create Button, Categories, and Forum Rules -->
        <aside class="col-md-3 mb-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <a href="{{ route('forum.create', ['projectId' => $projectId]) }}" class="btn btn-primary">
                        <i class="fas fa-pen"></i> Create Forum
                    </a>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h5">Forum Categories</h3>
                    <form action="{{ route('forum.index', ['projectId' => $projectId]) }}" method="GET">
                        <input type="hidden" name="projectId" value="{{ $projectId }}">
                        <div class="form-group">
                            <select name="category" id="category" class="form-control">
                                <option value="">All Categories</option>
                                <option value="Category 1" {{ $selectedCategory === 'Category 1' ? 'selected' : '' }}>Category 1</option>
                                <option value="Category 2" {{ $selectedCategory === 'Category 2' ? 'selected' : '' }}>Category 2</option>
                                <option value="Category 3" {{ $selectedCategory === 'Category 3' ? 'selected' : '' }}>Category 3</option>
                                <!-- Add more categories here -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter mr-2"></i> Filter
                        </button>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h5">Forum Rules</h3>
                    <ul class="list-unstyled">
                        <li>Be respectful and considerate of others.</li>
                        <li>No spamming or self-promotion.</li>
                        <li>Stay on-topic in discussions.</li>
                        <li>Report any inappropriate content.</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="h5">Announcements</h3>
                    <p>Stay updated with the latest forum announcements and news.</p>
                </div>
            </div>
        </aside>

        <!-- Right Section for Forum Threads -->
        <main class="col-md-9">
            <div class="card mb-4">
                <div class="card-body">
                    @if ($forumPosts->isEmpty())
                        <div class="text-center text-muted">
                            <i class="fas fa-info-circle fa-2x"></i> No forums found for "{{ $selectedCategory }}"
                        </div>
                    @endif

                    @foreach($forumPosts as $forumPost)
                    <div class="forum-card card mb-4 rounded-lg shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h2 class="h5">{{ $forumPost->title }}</h2>
                                <a href="{{ route('forum.view', ['projectId' => $projectId, 'forumPostId' => $forumPost->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-comments"></i> View Forum
                                </a>
                            </div>
                            <div class="d-flex text-muted mt-2">
                                <div class="mr-4">
                                    <i class="fas fa-user-circle mr-1"></i> {{ $forumPost->user->name }}
                                </div>
                                <div class="mr-4">
                                    <i class="far fa-clock mr-1"></i> {{ $forumPost->created_at->diffForHumans() }}
                                </div>
                                <div>
                                    <span class="badge badge-primary">{{ $forumPost->category }}</span>
                                </div>
                            </div>
                            <p class="mt-2">{{ \Illuminate\Support\Str::limit($forumPost->content, 150) }}</p>
                        </div>
                    </div>
                    @endforeach
                
                </div>
            </div>

            <!-- Pagination Links -->
            <div class="text-center">
                {{ $forumPosts->links() }}
            </div>
        </main>
    </div>
</div>

<!-- Custom CSS for Button and Card Styles -->
<style>
    /* Button Styles */
    .btn {
        display: inline-block;
        font-weight: 600;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.5rem 1.25rem;
        font-size: 0.875rem;
        line-height: 1.5;
        border-radius: 0.375rem;
        transition: all 0.15s ease-in-out;
        cursor: pointer;
    }

    .btn-primary {
        color: #fff;
        background-color: #3f58b0;
        border-color: #3f58b0;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #2c3e6b;
        border-color: #2c3e6b;
    }

    /* Card Styles */
    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, 0.125);
        border-radius: 0.375rem;
        transition: box-shadow 0.15s ease-in-out, border-color 0.15s ease-in-out;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1.25rem;
    }
</style>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
@endsection

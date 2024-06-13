@extends('layouts.app')

@section('content')
<div class="flex flex-col min-h-screen bg-light-blue">
    <!-- Header -->
    <header class="bg-navy-blue text-blue py-4 text-center">
        <h1 class="text-4xl font-extrabold flex items-center justify-center">
            <i class="fas fa-bug mr-2"></i> Bugtracking
        </h1>
    </header>

    <!-- Main Content -->
    <div class="flex-grow flex">
        <!-- Left Sidebar for Create Button, Categories, and Forum Rules -->
        <aside class="w-1/4 bg-white p-4 rounded-lg shadow-md">
            <div class="mb-4">
                <!-- Logo or Heading -->
                <h2 class="text-2xl font-semibold mb-4">Bugtracking Menu</h2>
                
                <!-- Menu Items -->
                <ul class="list-unstyled">
                    <li>
                        <a href="{{ route('bugtrack.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-full shadow-md text-lg block text-center transition duration-300 ease-in-out transform hover:scale-105 mb-2">
                            <i class="fas fa-bug"></i> Create Bugtrack
                        </a>
                    </li>
                    <li>
                        <a href="" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-full shadow-md text-lg block text-center transition duration-300 ease-in-out transform hover:scale-105 mb-2">
                            <i class="fas fa-tags"></i> Categories
                        </a>
                    </li>
                    <li>
                        <a href="" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-3 rounded-full shadow-md text-lg block text-center transition duration-300 ease-in-out transform hover:scale-105 mb-2">
                            <i class="fas fa-comments"></i> Forum
                        </a>
                    </li>
                    <!-- Add more menu items here -->
                </ul>
            </div>
        </aside>
    
        
        <!-- Right Section for Bugtrackings -->
        <main class="w-3/4 pl-4 flex-grow flex-col">
            <!-- Section for "Open" bugtrackings -->
            <div class="w-full p-4" id="openSection">
                <div class="bg-white p-4 rounded-lg shadow-md mb-4 droppable" data-status="open">
                    <h2 class="text-2xl font-semibold mb-4">Open</h2>
                    @forelse($bugtracks as $bugtrack)
                        @if($bugtrack->status === 'open')
                            <div class="bugtrack-card bg-blue-50 p-4 rounded-lg shadow-md mb-6 hover:shadow-lg hover:scale-105 draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                <!-- Bugtrack information -->
                                <h3 class="text-xl font-semibold">{{ $bugtrack->title }}</h3>
                                <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                <!-- Additional information (e.g., assigned to, reported by, etc.) -->
                                <div class="flex items-center text-gray-600 text-sm mt-2">
                                    <!-- Include additional information here -->
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>No bugtrackings found with status "Open".</p>
                    @endforelse
                </div>
            </div>

            <!-- Section for "In Progress" bugtrackings -->
            <div class="w-full p-4" id="progressSection">
                <div class="bg-white p-4 rounded-lg shadow-md mb-4 droppable" data-status="In Progress">
                    <h2 class="text-2xl font-semibold mb-4">In Progress</h2>
                    @forelse($bugtracks as $bugtrack)
                        @if($bugtrack->status === 'In Progress')
                            <div class="bugtrack-card bg-blue-50 p-4 rounded-lg shadow-md mb-6 hover:shadow-lg hover:scale-105 draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                <!-- Bugtrack information -->
                                <h3 class="text-xl font-semibold">{{ $bugtrack->title }}</h3>
                                <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                <!-- Additional information (e.g., assigned to, reported by, etc.) -->
                                <div class="flex items-center text-gray-600 text-sm mt-2">
                                    <!-- Include additional information here -->
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>No bugtrackings found with status "In Progress".</p>
                    @endforelse
                </div>
            </div>

            <!-- Section for "Closed" bugtrackings -->
            <div class="w-full p-4" id="closedSection">
                <div class="bg-white p-4 rounded-lg shadow-md mb-4 droppable" data-status="Closed">
                    <h2 class="text-2xl font-semibold mb-4">Closed</h2>
                    @forelse($bugtracks as $bugtrack)
                        @if($bugtrack->status === 'Closed')
                            <div class="bugtrack-card bg-blue-50 p-4 rounded-lg shadow-md mb-6 hover:shadow-lg hover:scale-105 draggable" data-id="{{ $bugtrack->id }}" draggable="true">
                                <!-- Bugtrack information -->
                                <h3 class="text-xl font-semibold">{{ $bugtrack->title }}</h3>
                                <p class="text-gray-700 text-lg mt-2">{{ \Illuminate\Support\Str::limit($bugtrack->description, 150) }}</p>
                                <!-- Additional information (e.g., assigned to, reported by, etc.) -->
                                <div class="flex items-center text-gray-600 text-sm mt-2">
                                    <!-- Include additional information here -->
                                </div>
                            </div>
                        @endif
                    @empty
                        <p>No bugtrackings found with status "Closed".</p>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <!-- Sidebar for bugtrack details -->
    <aside id="bugtrack-details-sidebar" class="fixed inset-y-0 right-0 w-1/4 bg-white p-4 rounded-l-lg shadow-md hidden">
        <!-- Detailed bugtrack information will be displayed here -->
    </aside>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white text-center py-3">
        &copy; {{ date('Y') }} Jeevan Bugtracking. All Rights Reserved.
    </footer>
</div>

<!-- Font Awesome CDN for icons -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>

<!-- JavaScript for drag and drop and displaying detailed information -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const bugtrackCards = document.querySelectorAll('.bugtrack-card');

        bugtrackCards.forEach(card => {
            card.addEventListener('click', () => {
                const bugId = card.dataset.id;

                // Fetch detailed information about the bugtrack item
                fetch(`/bugtrack/${bugId}/details`)
                    .then(response => response.json())
                    .then(data => {
                        // Display the detailed information in the sidebar
                        const sidebar = document.querySelector('#bugtrack-details-sidebar');
                        sidebar.innerHTML = `
                            <h3 class="text-xl font-semibold mb-2">${data.title}</h3>
                            <p class="text-gray-700 mb-4">${data.description}</p>
                            <p class="text-gray-600">Assigned to: ${data.assigned_to}</p>
                            <!-- Add more fields here as needed -->
                        `;

                        // Show the sidebar
                        sidebar.classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        const draggables = document.querySelectorAll('.draggable');
        const droppables = document.querySelectorAll('.droppable');

        draggables.forEach(draggable => {
            draggable.addEventListener('dragstart', () => {
                draggable.classList.add('dragging');
            });

            draggable.addEventListener('dragend', () => {
                draggable.classList.remove('dragging');
            });
        });

        droppables.forEach(droppable => {
            droppable.addEventListener('dragover', e => {
                e.preventDefault();
            });

            droppable.addEventListener('drop', e => {
                const draggable = document.querySelector('.dragging');
                const status = droppable.dataset.status;
                const bugId = draggable.dataset.id;

                // Send AJAX request to update bug status
                fetch(`/bugtrack/${bugId}/update-status`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ status: status })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        droppable.appendChild(draggable);
                        // Update the status in the UI if necessary
                    } else {
                        console.error('Failed to update bug status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
@endsection

<!-- tasks.kanban.blade.php -->
@extends('layouts.app')
@include('inc.style')

@section('content')

<div class="md:mx-4 relative overflow-hidden">
    <main class="h-full flex flex-col overflow-auto">
        {{-- give selection to choose which project to view kanban --}}
        <table id="userstories">
            <tr>
                <th>Project</th>
                <th>Kanban Board</th>
            </tr>
            
            @forelse($pro as $project)
                <tr> 
                    <th>
                        {{ $project->proj_name }}
                    </th>
                    <th>
                       
                        <button class="task-btn" data-id="{{ $project->id }}">View</button>
                    </th>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No projects added yet</td>
                </tr>
            @endforelse
        </table>
    </main>
</div>


<div class="fixed z-10 inset-0 overflow-y-auto" x-data="{ showModal : false }" x-show="showModal" @keydown.escape="showModal = false">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded shadow-md p-4">
            <div class="flex justify-between items-center border-b mb-4 pb-2">
                <h5 class="text-xl font-semibold" id="taskModalLabel">Task Description</h5>
                <button @click="showModal = false" class="text-gray-500 focus:outline-none">&times;</button>
            </div>
            <p id="taskDescription"></p>
        </div>
    </div>
</div>


<script>
    document.querySelectorAll('.task-btn').forEach(function (taskBtn) {
        taskBtn.addEventListener('click', function () {
            var projectId = taskBtn.getAttribute('data-id');
            // Redirect to viewkanban route passing the project id
            window.location.href = "{{ url('/tasks/viewkanban') }}/" + projectId;
        });
    });

    // Close modal on clicking outside the modal
    document.addEventListener('click', function (event) {
        if (!event.target.closest('.fixed')) {
            document.querySelector('.fixed').classList.remove('block');
        }
    });
</script>

@endsection

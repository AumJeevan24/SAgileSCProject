<!-- tasks.viewkanban.blade.php -->
@extends('layouts.app')
@include('inc.style')

@section('content')

<div class="md:mx-4 relative overflow-hidden">
    <main class="h-full flex flex-col overflow-auto">
        {{-- Displaying tasks as cards --}}
        <div class="container mt-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-columns">
                        @foreach($tasks as $task)
                            <div class="card task" data-description="{{ $task->description }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $task->title }}</h5>
                                    <p class="card-text">{{ $task->description }}</p>
                                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
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
    document.querySelectorAll('.task').forEach(function (task) {
        task.addEventListener('click', function () {
            var description = task.getAttribute('data-description');
            document.getElementById('taskDescription').textContent = description;
            document.querySelector('.fixed').classList.add('block');
        });
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.fixed')) {
            document.querySelector('.fixed').classList.remove('block');
        }
    });
</script>

@endsection

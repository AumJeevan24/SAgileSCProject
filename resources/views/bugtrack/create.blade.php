@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 p-8 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-semibold mb-8 text-center">Create a New Bugtrack</h1>
    <form action="{{ route('bugtrack.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-4 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Title -->
        <div class="mb-6">
            <label for="title" class="block text-gray-700 text-lg font-semibold mb-2 flex items-center">
                <span class="mr-2">Title</span>
                <span class="text-red-500">*</span>
            </label>
            <input type="text" id="title" name="title" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter the bug title" required autofocus>
        </div>
        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block text-gray-700 text-lg font-semibold mb-2 flex items-center">
                <span class="mr-2">Description</span>
                <span class="text-red-500">*</span>
            </label>
            <textarea id="description" name="description" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline h-64 resize-none" placeholder="Enter the bug description" required></textarea>
            <p class="text-gray-500 text-sm mt-2">Max 500 characters</p>
        </div>
        <!-- Severity and Status -->
        <div class="flex mb-6">
            <div class="w-1/2 pr-4">
                <label for="severity" class="block text-gray-700 text-lg font-semibold mb-2">Severity</label>
                <select id="severity" name="severity" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" required>
                    <option value="low">Low</option>
                    <option value="medium" selected>Medium</option>
                    <option value="high">High</option>
                </select>
            </div>
            <div class="w-1/2 pl-4">
                <label for="status" class="block text-gray-700 text-lg font-semibold mb-2">Status</label>
                <select id="status" name="status" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" required>
                    <option value="open" selected>Open</option>
                    <option value="closed">Closed</option>
                    <option value="pending">Pending</option>
                </select>
            </div>
        </div>
        <!-- Flow -->
        <div class="mb-6">
            <label for="flow" class="block text-gray-700 text-lg font-semibold mb-2">Flow</label>
            <input type="text" id="flow" name="flow" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter the bug flow">
        </div>
        <!-- Expected Results -->
        <div class="mb-6">
            <label for="expected_results" class="block text-gray-700 text-lg font-semibold mb-2">Expected Results</label>
            <textarea id="expected_results" name="expected_results" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline h-32 resize-none" placeholder="Enter the expected results"></textarea>
        </div>
        <!-- Actual Results -->
        <div class="mb-6">
            <label for="actual_results" class="block text-gray-700 text-lg font-semibold mb-2">Actual Results</label>
            <textarea id="actual_results" name="actual_results" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline h-32 resize-none" placeholder="Enter the actual results"></textarea>
        </div>
        <!-- Attachment -->
        <div class="mb-6">
            <label for="attachment" class="block text-gray-700 text-lg font-semibold mb-2">Attachment</label>
            <input type="text" id="attachment" name="attachment" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter the attachment">
        </div>
        <!-- Assigned To and Reported By -->
        <div class="flex mb-6">
            <div class="w-1/2 pr-4">
                <label for="assigned_to" class="block text-gray-700 text-lg font-semibold mb-2">Assigned To</label>
                <input type="text" id="assigned_to" name="assigned_to" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter assigned to">
            </div>
            <div class="w-1/2 pl-4">
                <label for="reported_by" class="block text-gray-700 text-lg font-semibold mb-2">Reported By</label>
                <input type="text" id="reported_by" name="reported_by" class="w-full px-4 py-3 border rounded-lg focus:outline-none focus:shadow-outline" placeholder="Enter reported by">
            </div>
        </div>
        <!-- Submit Button -->
        <div class="flex justify-center mt-8 space-x-4">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-3 px-8 rounded-lg shadow-md text-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-check mr-2"></i> Create Bugtrack
            </button>
            <a href="{{ route('bugtrack.index') }}" class="text-gray-600 hover:text-gray-800 py-3 px-8 rounded-lg border border-gray-300 hover:border-gray-500 text-lg transition duration-300 ease-in-out transform hover:scale-105">
                <i class="fas fa-times mr-2"></i> Cancel
            </a>
        </div>
    </form>
</div>

<!-- JavaScript to count characters -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const descriptionTextarea = document.getElementById('description');
        const expectedResultsTextarea = document.getElementById('expected_results');
        const actualResultsTextarea = document.getElementById('actual_results');

        descriptionTextarea.addEventListener('input', function () {
            document.getElementById('charCountDescription').textContent = this.value.length;
        });

        expectedResultsTextarea.addEventListener('input', function () {
            document.getElementById('charCountExpectedResults').textContent = this.value.length;
        });

        actualResultsTextarea.addEventListener('input', function () {
            document.getElementById('charCountActualResults').textContent = this.value.length;
        });
    });
</script>

@endsection

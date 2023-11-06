<!-- resources/views/components/delete-alert.blade.php -->

<div id="deleteAlert" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white w-1/3 p-6 rounded-lg shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
        <p class="mb-4">Are you sure you want to delete this item?</p>
        <div class="flex justify-end">
            <button id="confirmDelete" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-full mr-2">
                Yes
            </button>
            <button id="cancelDelete" class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-full">
                Cancel
            </button>
        </div>
    </div>
</div>

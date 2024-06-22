<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bugtracking;

class BugtrackingController extends Controller
{

    public function index()
    {
        // Fetch all bugtrackings from the database
        $bugtracks = Bugtracking::all();

        // Get unique statuses from bugtrackings
        $statuses = $bugtracks->unique('status')->pluck('status');

        // Return the view with bugtracks data and statuses
        return view('bugtrack.index', compact('bugtracks', 'statuses'));
    }

    public function create()
    {
        return view('bugtrack.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'string|max:255',
            'status' => 'string|max:255',
            'flow' => 'nullable|string',
            'expected_results' => 'nullable|string',
            'actual_results' => 'nullable|string',
            'attachment' => 'nullable|string',
            'assigned_to' => 'nullable',
            'reported_by' => 'nullable',
        ]);
    
        // Set default values for assigned_to and reported_by if not provided
        $validatedData['assigned_to'] = $validatedData['assigned_to'] ?? 1; // Change 1 to the default user ID
        $validatedData['reported_by'] = $validatedData['reported_by'] ?? 1; // Change 1 to the default user ID
    
        // Create new Bugtrack instance
        $bugtrack = Bugtracking::create($validatedData);
    
        // Redirect after successful creation
        return redirect()->route('bugtrack.index')->with('success', 'Bug created successfully');
    }

    public function updateStatus(Request $request, $bugId)
    {
        // Validate the request
        $request->validate([
            'status' => 'required|string|in:Open,In Progress,Closed',
        ]);

        // Find the bug by its ID
        $bugtrack = Bugtracking::findOrFail($bugId);

        // Update the status
        $bugtrack->status = $request->status;
        $bugtrack->save();

        // Return a JSON response indicating success
        return response()->json(['success' => true]);
    }

    public function details($id)
{
    // Fetch the bugtrack item from the database
    $bugtrack = Bugtracking::findOrFail($id);

    // Return the detailed information as JSON
    return response()->json([
        'title' => $bugtrack->title,
        'description' => $bugtrack->description,
        'assigned_to' => $bugtrack->assigned_to,
        // Add more fields as needed
    ]);
}

}

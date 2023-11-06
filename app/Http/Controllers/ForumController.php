<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;


class ForumController extends Controller
{
    public function index(Request $request)
{
    $categoryFilter = $request->input('category'); // Get the selected category from the request

    // Query forums based on the selected category, or fetch all if no category is selected
    $forumPosts = Forum::when($categoryFilter, function ($query) use ($categoryFilter) {
        return $query->where('category', $categoryFilter);
    })
    ->orderBy('created_at', 'desc')
    ->paginate(10);

    return view('forum.index', [
        'forumPosts' => $forumPosts,
        'selectedCategory' => $categoryFilter, // Pass the selected category to the view
    ]);
}

public function view($id)
{
    // Fetch the forum post by ID
    $forumPost = Forum::find($id);

    if (!$forumPost) {
        // Handle the case when the forum post is not found
        return redirect()->route('forum.index')->with('error', 'Forum not found.');
    }

    return view('forum.view', ['forumPost' => $forumPost]);
}
    
    
    public function create()
{
    return view('forum.create'); // You can create a 'create' view for the forum creation form
}

    public function store(Request $request)
{
    // Validation rules can be added here
    $validatedData = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'category' => 'required|string', // Assuming you have a category field
        'image_url' => 'nullable|string|url', // Validate image URL as a valid URL
        // Add any other validation rules you need
    ]);

    // Create a new forum
    Forum::create([
        'title' => $validatedData['title'],
        'content' => $validatedData['content'],
        'category' => $validatedData['category'],
        'image_urls' => $validatedData['image_url'], // Store image URL if provided
        'user_id' => auth()->user()->id, // Assuming you have user authentication
    ]);
    // Redirect to the forum index or show page
    return redirect()->route('forum.index');
}

public function update(Request $request, Forum $forumPost)
{
    // Validation and update logic here
    // You can access the forum post using $forumPost
    $forumPost->update(['content' => $request->input('updatedContent')]);

    // Redirect back to the forum post view or any other desired location
    return redirect()->route('forum.view', ['id' => $forumPost->id]);
}


public function edit($id)
{
    $forumPost = Forum::findOrFail($id); // Retrieve the forum post by ID
    // Add any additional logic if needed

    return view('forum.edit', ['forumPost' => $forumPost]);
}

public function destroy(Forum $forumPost)
{
    // Perform validation or authorization checks here, if needed.

    // Delete the forum post.
    $forumPost->delete();

    return redirect()->route('forum.index')->with('success', 'Forum post deleted successfully');

}





}

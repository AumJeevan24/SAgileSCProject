<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Forum;
use Illuminate\Support\Facades\Auth; // Import the Auth facade

class CommentController extends Controller
{
    public function store(Request $request, $forum_id)
    {
        // Validate the request data as needed
        $validatedData = $request->validate([
            'content' => 'required|string',
        ]);
    
        // Create a new comment with the user_id set to the currently authenticated user
        $comment = new Comment([
            'content' => $validatedData['content'],
            'user_id' => Auth::id(),
            'forum_id' => $forum_id, // Pass the forum_id here
        ]);
    
        // Save the comment
        $comment->save();
    
        // Redirect back to the forum post view page
        return back()->with('success', 'Comment added successfully!');
    }
    
}

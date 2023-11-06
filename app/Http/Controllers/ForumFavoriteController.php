<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ForumFavorite;

class ForumFavoriteController extends Controller
{
    public function toggleFavorite(Request $request, $forumId)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirect to login if not logged in
        }

        // Get the current user
        $user = auth()->user();

        // Check if the user has already favorited the forum
        $existingFavorite = ForumFavorite::where('user_id', $user->id)
            ->where('forum_id', $forumId)
            ->first();

        if ($existingFavorite) {
            // If already favorited, remove the favorite
            $existingFavorite->delete();
        } else {
            // If not favorited, add it as a favorite
            ForumFavorite::create([
                'user_id' => $user->id,
                'forum_id' => $forumId,
            ]);
        }

        // Redirect back to the forum or wherever you prefer
        return redirect()->back();
    }

    public function toggleUnfavorite(Request $request, $forumId)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login'); // Redirect to login if not logged in
        }

        // Get the current user
        $user = auth()->user();

        // Check if the user has favorited the forum
        $existingFavorite = ForumFavorite::where('user_id', $user->id)
            ->where('forum_id', $forumId)
            ->first();

        if ($existingFavorite) {
            // If favorited, remove the favorite
            $existingFavorite->delete();
        }

        // Redirect back to the forum or wherever you prefer
        return redirect()->back();
    }
}
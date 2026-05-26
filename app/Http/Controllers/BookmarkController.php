<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'genre_id' => 'nullable|exists:genres,id',
        ]);

        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = auth()->user();
        $bookmark = Bookmark::where('user_id', $user->id)
            ->where('game_id', $request->game_id)
            ->where('genre_id', $request->genre_id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return response()->json(['status' => 'removed']);
        }

        Bookmark::create([
            'user_id' => $user->id,
            'game_id' => $request->game_id,
            'genre_id' => $request->genre_id,
        ]);

        return response()->json(['status' => 'added']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->has('challenges')->get();
        return view('home', compact('games'));
    }

    public function games(Request $request)
    {
        $selectedGenreSlug = $request->query('genre');
        $query = Game::where('is_active', true)->has('challenges');

        if ($selectedGenreSlug) {
            $query->whereHas('challenges.genre', function ($q) use ($selectedGenreSlug) {
                $q->where('slug', $selectedGenreSlug);
            });
        }

        $games = $query->get();
        $genres = Genre::whereHas('challenges.game', function ($q) {
            $q->where('is_active', true);
        })->get();

        $selectedGenre = $selectedGenreSlug ? Genre::where('slug', $selectedGenreSlug)->first() : null;

        return view('games.index', compact('games', 'genres', 'selectedGenre'));
    }
}

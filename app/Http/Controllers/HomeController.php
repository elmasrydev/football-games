<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();
        $query = Game::where('is_active', true)
            ->whereHas('challenges', function($q) use ($locale) {
                $q->where('language', $locale)->where('is_active', true);
            });

        $games = (clone $query)->get();
        $latestGames = (clone $query)->latest()->limit(2)->get();
        
        $genres = Genre::whereHas('challenges', function ($q) use ($locale) {
            $q->where('language', $locale)->where('is_active', true);
        })->get();
            
        return view('home', compact('games', 'latestGames', 'genres'));
    }

    public function games(Request $request)
    {
        $locale = app()->getLocale();
        
        $genres = Genre::whereHas('challenges', function ($q) use ($locale) {
            $q->where('language', $locale)->where('is_active', true);
        })->withCount(['games' => function($q) {
            $q->where('is_active', true);
        }])->get();

        $totalGamesCount = Game::where('is_active', true)->count();

        return view('games.index', compact('genres', 'totalGamesCount'));
    }

    public function genreGames(string $locale, string $genreSlug)
    {
        $genre = Genre::where('slug', $genreSlug)->firstOrFail();
        
        $games = Game::where('is_active', true)
            ->whereHas('genres', function($q) use ($genre) {
                $q->where('genres.id', $genre->id);
            })
            ->whereHas('challenges', function($q) use ($locale) {
                $q->where('language', $locale)->where('is_active', true);
            })
            ->get();

        return view('games.genre', compact('genre', 'games'));
    }
}

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
        $games = Game::where('is_active', true)
            ->whereHas('challenges', function($q) use ($locale) {
                $q->where('language', $locale)->where('is_active', true);
            })->get();
            
        return view('home', compact('games'));
    }

    public function games(Request $request)
    {
        $locale = app()->getLocale();
        $selectedGenreSlug = $request->query('genre');
        
        $query = Game::where('is_active', true)
            ->whereHas('challenges', function($q) use ($locale) {
                $q->where('language', $locale)->where('is_active', true);
            });

        if ($selectedGenreSlug) {
            $query->whereHas('challenges.genre', function ($q) use ($selectedGenreSlug, $locale) {
                $q->where('slug', $selectedGenreSlug);
            });
        }

        $games = $query->get();
        
        $genres = Genre::whereHas('challenges', function ($q) use ($locale) {
            $q->where('language', $locale)->where('is_active', true);
        })->get();

        $selectedGenre = $selectedGenreSlug ? Genre::where('slug', $selectedGenreSlug)->first() : null;

        return view('games.index', compact('games', 'genres', 'selectedGenre'));
    }
}

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
            ->where(function($q) use ($locale) {
                $q->whereHas('challenges', function($sub) use ($locale) {
                    $sub->where('language', $locale)->where('is_active', true);
                })->orWhere('slug', 'mazad');
            });

        $games = (clone $query)->with(['challenges' => function($q) use ($locale) {
            $q->where('language', $locale)->where('is_active', true);
        }])->get();
        $latestGames = (clone $query)->latest()->limit(2)->get();
        
        $genres = Genre::where('is_active', true)
            ->whereHas('challenges', function ($q) use ($locale) {
                $q->where('language', $locale)->where('is_active', true);
            })
            ->orderBy('sort_order')
            ->get();

        app(\App\Services\SEOService::class)
            ->set('title', __('Games Hub'))
            ->set('description', __('Experience the best online games on Gamesiano. Play now!'));
            
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

        app(\App\Services\SEOService::class)
            ->set('title', __('Game Library'))
            ->set('description', __('Browse our extensive library of games across all categories.'));

        return view('games.index', compact('genres', 'totalGamesCount'));
    }

    public function genreGames(string $locale, string $genreSlug)
    {
        $genre = Genre::where('slug', $genreSlug)->firstOrFail();
        
        $games = Game::where('is_active', true)
            ->whereHas('genres', function($q) use ($genre) {
                $q->where('genres.id', $genre->id);
            })
            ->where(function($q) use ($locale) {
                $q->whereHas('challenges', function($sub) use ($locale) {
                    $sub->where('language', $locale)->where('is_active', true);
                })->orWhere('slug', 'mazad');
            })
            ->get();

        app(\App\Services\SEOService::class)
            ->set('title', $genre->localized_name . ' ' . __('Games'))
            ->set('description', __('Explore the best :genre games and challenges.', ['genre' => $genre->localized_name]));

        return view('games.genre', compact('genre', 'games'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Genre;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $locales = ['en', 'ar'];
        $urls = [];

        foreach ($locales as $locale) {
            // Static pages
            $urls[] = $this->makeUrl(route('home', ['locale' => $locale]), '1.0', 'daily');
            $urls[] = $this->makeUrl(route('games.index', ['locale' => $locale]), '0.8', 'daily');
            $urls[] = $this->makeUrl(route('about', ['locale' => $locale]), '0.5', 'monthly');
            $urls[] = $this->makeUrl(route('contact', ['locale' => $locale]), '0.5', 'monthly');

            // Genre pages
            $genres = Genre::whereHas('challenges', function($q) use ($locale) {
                $q->where('language', $locale)->where('is_active', true);
            })->get();

            foreach ($genres as $genre) {
                $urls[] = $this->makeUrl(route('games.genre', ['locale' => $locale, 'genre_slug' => $genre->slug]), '0.7', 'weekly');
            }

            // Game pages
            $games = Game::where('is_active', true)
                ->whereHas('challenges', function($q) use ($locale) {
                    $q->where('language', $locale)->where('is_active', true);
                })->get();

            foreach ($games as $game) {
                $urls[] = $this->makeUrl(route('games.play', ['locale' => $locale, 'slug' => $game->slug]), '0.9', 'weekly');
            }
        }

        $xml = view('sitemap', compact('urls'))->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }

    protected function makeUrl($loc, $priority, $changefreq)
    {
        return (object) [
            'loc' => $loc,
            'priority' => $priority,
            'changefreq' => $changefreq,
            'lastmod' => now()->toAtomString(),
        ];
    }
}

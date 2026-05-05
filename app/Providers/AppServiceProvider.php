<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\Facades\Vite;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(\App\Services\SEOService::class, function ($app) {
            return new \App\Services\SEOService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('background-remover', Vite::asset('resources/js/background-remover.js')),
        ]);

        \App\Models\Challenge::observe(\App\Observers\ChallengeObserver::class);
        $request = request();

        $locale = $request->segment(1)
            ?? ($request->hasSession() ? $request->session()->get('locale') : null)
            ?? $request->cookie('locale')
            ?? config('app.locale');

        if (in_array($locale, ['en', 'ar'], true)) {
            App::setLocale($locale);
            URL::defaults(['locale' => $locale]);
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            $rawStats = request()->cookie('game_stats');
            
            if (is_string($rawStats)) {
                $stats = json_decode($rawStats, true) ?: [];
            } else {
                $stats = (array) $rawStats;
            }

            $stats = array_merge([
                'streak' => 0,
                'last_played_at' => null,
                'total_correct' => 0,
                'total_questions' => 0,
                'games_played' => 0,
            ], $stats);

            $locale = App::currentLocale();
            $genres = \App\Models\Genre::where('is_active', true)
                ->whereHas('challenges', function($query) {
                    $query->where('is_active', true);
                })
                ->orderBy('sort_order')
                ->get();
            
            $view->with('global_stats', $stats)
                ->with('current_locale', $locale)
                ->with('current_direction', $locale === 'ar' ? 'rtl' : 'ltr')
                ->with('all_genres', $genres)
                ->with('seo', app(\App\Services\SEOService::class));
        });
    }
}

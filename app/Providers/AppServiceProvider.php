<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
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
            
            $view->with('global_stats', $stats);
        });
    }
}

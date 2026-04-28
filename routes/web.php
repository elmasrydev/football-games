<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GamePlayController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/games', [HomeController::class, 'games'])->name('games.index');

// Unified Game Routes
Route::get('/games/{slug}/{challenge?}', [GamePlayController::class, 'play'])->name('games.play');
Route::post('/challenges/{challenge}/check', [GamePlayController::class, 'checkAnswer'])->name('challenges.check');
Route::post('/challenges/{challenge}/hint', [GamePlayController::class, 'getHint'])->name('challenges.hint');
Route::get('/challenges/{challenge}/reveal', [GamePlayController::class, 'revealAnswer'])->name('challenges.reveal');

// Search Utilities
Route::get('/search/{type}', [GamePlayController::class, 'search'])->name('search.unified');

// Informational Pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');

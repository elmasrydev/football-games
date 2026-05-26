<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\GamePlayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Auth\SocialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google/redirect', [SocialController::class, 'redirectToGoogle'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [SocialController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::post('/logout', function() {
    Auth::logout();
    return redirect()->route('home', ['locale' => app()->getLocale()]);
})->name('logout');

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::pattern('locale', 'en|ar');

Route::get('/', function (Request $request) {
    $locale = $request->hasSession()
        ? $request->session()->get('locale', $request->cookie('locale', config('app.locale')))
        : $request->cookie('locale', config('app.locale'));

    $locale = in_array($locale, ['en', 'ar'], true) ? $locale : config('app.locale');

    return redirect()->route('home', ['locale' => $locale]);
});

Route::get('/login', function (Request $request) {
    $locale = $request->hasSession()
        ? $request->session()->get('locale', $request->cookie('locale', config('app.locale')))
        : $request->cookie('locale', config('app.locale'));
    $locale = in_array($locale, ['en', 'ar'], true) ? $locale : config('app.locale');
    return redirect()->route('login', ['locale' => $locale]);
});

Route::get('/register', function (Request $request) {
    $locale = $request->hasSession()
        ? $request->session()->get('locale', $request->cookie('locale', config('app.locale')))
        : $request->cookie('locale', config('app.locale'));
    $locale = in_array($locale, ['en', 'ar'], true) ? $locale : config('app.locale');
    return redirect()->route('register', ['locale' => $locale]);
});

Route::post('/preferences/locale', function (Request $request) {
    $locale = $request->string('locale')->toString();
    $currentUrl = $request->string('current_url')->toString();

    abort_unless(in_array($locale, ['en', 'ar'], true), 422);

    if ($request->hasSession()) {
        $request->session()->put('locale', $locale);
    }

    Cookie::queue('locale', $locale, 60 * 24 * 365);

    $redirectUrl = route('home', ['locale' => $locale]);

    if ($currentUrl !== '') {
        $parsed = parse_url($currentUrl);
        $path = $parsed['path'] ?? '/';
        $query = isset($parsed['query']) ? '?' . $parsed['query'] : '';

        if (preg_match('#^/(en|ar)(/.*)?$#', $path, $matches)) {
            $redirectUrl = '/' . $locale . ($matches[2] ?? '') . $query;
        } else {
            $redirectUrl = '/' . $locale . ($path === '/' ? '' : $path) . $query;
        }
    }

    return response()->json([
        'locale' => $locale,
        'direction' => $locale === 'ar' ? 'rtl' : 'ltr',
        'redirect_url' => $redirectUrl,
    ]);
})->name('preferences.locale');

Route::prefix('{locale}')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    
    // Auth Routes (Localized)
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');

    // Unified Game Routes
    Route::get('/games/{slug}/{challenge?}', [GamePlayController::class, 'play'])->name('games.play');

    Route::get('/library', [HomeController::class, 'games'])->name('games.index');
    Route::get('/multiplayer', [HomeController::class, 'multiplayer'])->name('multiplayer.index');
    Route::get('/library/{genre_slug}', [HomeController::class, 'genreGames'])->name('games.genre');
    Route::post('/challenges/{challenge}/check', [GamePlayController::class, 'checkAnswer'])->name('challenges.check');
    Route::post('/challenges/{challenge}/hint', [GamePlayController::class, 'getHint'])->name('challenges.hint');
    Route::get('/challenges/{challenge}/reveal', [GamePlayController::class, 'revealAnswer'])->name('challenges.reveal');

    // Search Utilities
    Route::get('/search/{type}', [GamePlayController::class, 'search'])->name('search.unified');

    // Bookmark Utility
    Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

    // Profile Management
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    });

    // Informational Pages
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/disclaimer', [PageController::class, 'disclaimer'])->name('disclaimer');
});
Route::get('/auth/expo/callback', function () { return view('auth.expo-proxy'); });

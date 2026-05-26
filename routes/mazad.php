<?php

use App\Http\Controllers\Mazad\GameController;
use App\Http\Controllers\Mazad\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mazad API Routes
|--------------------------------------------------------------------------
|
| These routes handle the Mazad multiplayer speed game API.
| All routes require authentication via Sanctum/session.
|
*/

Route::middleware(['web', 'auth'])->prefix('{locale}/mazad')->group(function () {
    // Room management
    Route::get('/rooms', [RoomController::class, 'index'])->name('mazad.rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('mazad.rooms.store');
    Route::get('/rooms/{code}', [RoomController::class, 'show'])->name('mazad.rooms.show');
    Route::post('/rooms/{code}/join', [RoomController::class, 'join'])->name('mazad.rooms.join');
    Route::post('/rooms/{code}/leave', [RoomController::class, 'leave'])->name('mazad.rooms.leave');
    Route::delete('/rooms/{code}', [RoomController::class, 'destroy'])->name('mazad.rooms.destroy');

    // Team management
    Route::post('/rooms/{code}/teams/auto', [RoomController::class, 'autoAssignTeams'])->name('mazad.teams.auto');
    Route::post('/rooms/{code}/teams/assign', [RoomController::class, 'assignTeam'])->name('mazad.teams.assign');

    // Gameplay
    Route::post('/rooms/{code}/start', [GameController::class, 'start'])->name('mazad.game.start');
    Route::post('/rooms/{code}/answer', [GameController::class, 'answer'])->name('mazad.game.answer');
    Route::get('/rooms/{code}/results', [GameController::class, 'results'])->name('mazad.game.results');
});

/*
|--------------------------------------------------------------------------
| Mazad Web Routes (Blade Views)
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->prefix('{locale}/mazad')->group(function () {
    // Lobby - list of public rooms
    Route::get('/', function (string $locale) {
        app()->setLocale($locale);
        return view('mazad.lobby');
    })->name('mazad.lobby');

    // Room view - waiting room / game
    Route::get('/room/{code}', function (string $locale, string $code) {
        app()->setLocale($locale);
        return view('mazad.room', ['code' => $code]);
    })->name('mazad.room');
});

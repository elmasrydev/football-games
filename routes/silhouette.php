<?php

use App\Http\Controllers\Silhouette\GameController;
use App\Http\Controllers\Silhouette\RoomController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Silhouette API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->prefix('{locale}/silhouette')->group(function () {
    // Room management
    Route::get('/rooms', [RoomController::class, 'index'])->name('silhouette.rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('silhouette.rooms.store');
    Route::get('/rooms/{code}', [RoomController::class, 'show'])->name('silhouette.rooms.show');
    Route::post('/rooms/{code}/join', [RoomController::class, 'join'])->name('silhouette.rooms.join');
    Route::post('/rooms/{code}/leave', [RoomController::class, 'leave'])->name('silhouette.rooms.leave');
    Route::delete('/rooms/{code}', [RoomController::class, 'destroy'])->name('silhouette.rooms.destroy');

    // Team management
    Route::post('/rooms/{code}/teams/auto', [RoomController::class, 'autoAssignTeams'])->name('silhouette.teams.auto');
    Route::post('/rooms/{code}/teams/assign', [RoomController::class, 'assignTeam'])->name('silhouette.teams.assign');

    // Gameplay
    Route::post('/rooms/{code}/start', [GameController::class, 'start'])->name('silhouette.game.start');
    Route::post('/rooms/{code}/answer', [GameController::class, 'answer'])->name('silhouette.game.answer');
    Route::get('/rooms/{code}/results', [GameController::class, 'results'])->name('silhouette.game.results');
});

/*
|--------------------------------------------------------------------------
| Silhouette Web Routes (Blade Views)
|--------------------------------------------------------------------------
*/

Route::middleware(['web'])->prefix('{locale}/silhouette')->group(function () {
    // Lobby - list of public rooms
    Route::get('/', function (string $locale) {
        app()->setLocale($locale);
        return view('silhouette.lobby');
    })->name('silhouette.lobby');

    // Room view - waiting room / game
    Route::get('/room/{code}', function (string $locale, string $code) {
        app()->setLocale($locale);
        return view('silhouette.room', ['code' => $code]);
    })->name('silhouette.room');
});

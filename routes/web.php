<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\BlackWhiteController;
use App\Http\Controllers\StadiumSpotterController;
use App\Http\Controllers\CelebrationStationController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\KitDetectiveController;
use App\Http\Controllers\TrophyHunterController;
use App\Http\Controllers\SilhouetteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/games', [HomeController::class, 'games'])->name('games.index');

// Stadium Spotter Game Routes (MUST come before wildcard {game} route)
Route::get('/games/stadium-spotter/{stadium?}', [StadiumSpotterController::class, 'play'])->name('games.stadium.play');
Route::post('/stadiums/{stadium}/check', [StadiumSpotterController::class, 'checkAnswer']);
Route::post('/stadiums/{stadium}/hint', [StadiumSpotterController::class, 'getHint']);

// Career Path Game Routes
Route::get('/games/career/{challenge?}', [CareerController::class, 'play'])->name('games.career.play');
Route::post('/career/{challenge}/check', [CareerController::class, 'checkAnswer'])->name('career.check');
Route::post('/career/{challenge}/hint', [CareerController::class, 'getHint'])->name('career.hint');

// Kit Detective Game Routes
Route::get('/games/kit-detective/{challenge?}', [KitDetectiveController::class, 'play'])->name('games.kit.play');
Route::post('/kits/{challenge}/check', [KitDetectiveController::class, 'checkAnswer'])->name('kits.check');
Route::post('/kits/{challenge}/hint', [KitDetectiveController::class, 'getHint'])->name('kits.hint');

// Trophy Hunter Game Routes
Route::get('/games/trophy-hunter/{video?}', [TrophyHunterController::class, 'play'])->name('games.trophy.play');
Route::post('/trophies/{video}/check', [TrophyHunterController::class, 'checkAnswer'])->name('trophies.check');
Route::post('/trophies/{video}/hint', [TrophyHunterController::class, 'getHint'])->name('trophies.hint');

// Guess the Silhouette Game Routes
Route::get('/games/guess-silhouette/{challenge?}', [SilhouetteController::class, 'play'])->name('games.silhouette.play');
Route::post('/silhouettes/{challenge}/check', [SilhouetteController::class, 'checkAnswer'])->name('silhouettes.check');
Route::post('/silhouettes/{challenge}/hint', [SilhouetteController::class, 'getHint'])->name('silhouettes.hint');

// Celebration Station Game Routes
Route::get('/games/celebration-station/{video?}', [CelebrationStationController::class, 'play'])->name('games.celebration.play');

// Black & White Game Routes (wildcard catches all other games)
Route::get('/games/{game}/{video?}', [BlackWhiteController::class, 'play'])->name('games.bw.play');
Route::post('/videos/{video}/check', [BlackWhiteController::class, 'checkAnswer'])->name('videos.check');
Route::post('/videos/{video}/hint', [BlackWhiteController::class, 'getHint'])->name('videos.hint');

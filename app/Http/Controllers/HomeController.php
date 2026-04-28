<?php

namespace App\Http\Controllers;

use App\Models\Game;

class HomeController extends Controller
{
    public function index()
    {
        $games = Game::where('is_active', true)->get();
        return view('home', compact('games'));
    }

    public function games()
    {
        $games = Game::where('is_active', true)->get();
        return view('games.index', compact('games'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Game;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function games()
    {
        $games = Game::where('is_active', true)->get();
        return view('games.index', compact('games'));
    }
}

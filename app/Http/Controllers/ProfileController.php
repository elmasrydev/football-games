<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        app(\App\Services\SEOService::class)
            ->set('title', __('Profile'))
            ->set('description', __('Manage your Gamesiano account profile and preferences.'));

        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->save();

        return redirect()->route('profile.edit', ['locale' => app()->getLocale()])
            ->with('success', __('Profile updated successfully'));
    }
}

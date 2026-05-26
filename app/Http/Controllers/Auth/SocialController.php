<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function redirectToGoogle(Request $request)
    {
        if ($request->query('platform') === 'mobile') {
            session(['auth_platform' => 'mobile']);
            session(['auth_redirect_scheme' => $request->query('redirect_scheme', 'gamesmobile')]);
        } else {
            session()->forget(['auth_platform', 'auth_redirect_scheme']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'name' => $googleUser->getName(),
                ]);
            } else {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => null,
                ]);
            }

            if (session('auth_platform') === 'mobile') {
                $scheme = session('auth_redirect_scheme', 'gamesmobile');
                session()->forget(['auth_platform', 'auth_redirect_scheme']);
                
                // Revoke old mobile tokens for security
                $user->tokens()->delete();
                
                // Generate secure Sanctum token
                $token = $user->createToken('mobile-auth-token')->plainTextToken;
                
                // Package user details for the mobile app
                $userPayload = urlencode(json_encode([
                    'id' => (string) $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                ]));
                
                // Redirect back to our React Native custom URL scheme callback
                return redirect($scheme . '://auth-callback?token=' . $token . '&user=' . $userPayload);
            }

            Auth::login($user);

            return redirect()->route('home', ['locale' => app()->getLocale()]);
        } catch (\Exception $e) {
            if (session('auth_platform') === 'mobile') {
                $scheme = session('auth_redirect_scheme', 'gamesmobile');
                session()->forget(['auth_platform', 'auth_redirect_scheme']);
                return redirect($scheme . '://auth-callback?error=' . urlencode('Something went wrong: ' . $e->getMessage()));
            }
            return redirect()->route('login', ['locale' => app()->getLocale()])->with('error', 'Something went wrong with Google login.');
        }
    }
}

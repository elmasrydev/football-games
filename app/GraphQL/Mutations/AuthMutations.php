<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Google_Client;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class AuthMutations
{
    /**
     * Handle mobile Google OAuth login.
     * Supports both id_token (JWT) and access_token.
     *
     * @param null $_
     * @param array<string, mixed> $args
     * @return array<string, mixed>
     */
    public function socialLogin($_, array $args): array
    {
        $provider = $args['provider'];
        $token = $args['token'];

        if ($provider !== 'google') {
            throw new Exception("Unsupported authentication provider: {$provider}");
        }

        $googleId = null;
        $email = null;
        $name = '';
        $avatar = '';

        // Attempt 1: Verify as id_token using Google_Client
        try {
            $client = new Google_Client(['client_id' => config('services.google.client_id')]);
            $payload = $client->verifyIdToken($token);

            if ($payload) {
                $googleId = $payload['sub'];
                $email = $payload['email'];
                $name = $payload['name'] ?? '';
                $avatar = $payload['picture'] ?? '';
            }
        } catch (Exception $e) {
            Log::warning('Google verifyIdToken failed, falling back to Socialite userFromToken: ' . $e->getMessage());
        }

        // Attempt 2: Fallback to Socialite userFromToken (if token is an access_token)
        if (!$email) {
            try {
                $googleUser = Socialite::driver('google')->stateless()->userFromToken($token);
                $googleId = $googleUser->getId();
                $email = $googleUser->getEmail();
                $name = $googleUser->getName();
                $avatar = $googleUser->getAvatar();
            } catch (Exception $e) {
                Log::error('Socialite userFromToken also failed: ' . $e->getMessage());
                throw new Exception("Invalid Google token provided.");
            }
        }

        if (!$email) {
            throw new Exception("Unable to retrieve email from Google token.");
        }

        // Find or create user
        $user = User::where('email', $email)->first();

        if ($user) {
            $user->update([
                'google_id' => $googleId,
                'avatar' => $avatar ?: $user->avatar,
                'name' => $name ?: $user->name,
            ]);
        } else {
            $user = User::create([
                'name' => $name ?: 'Google User',
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar,
                'password' => null,
            ]);
        }

        // Revoke existing mobile tokens to keep session clean
        $user->tokens()->where('name', 'mobile')->delete();

        // Create new Sanctum token
        $tokenResult = $user->createToken('mobile');

        return [
            'token' => $tokenResult->plainTextToken,
            'user' => $user,
        ];
    }

    /**
     * Logout current user by revoking their current access token.
     *
     * @param null $_
     * @param array<string, mixed> $args
     * @return bool
     */
    public function logout($_, array $args): bool
    {
        $user = auth()->guard('api')->user();

        if ($user && method_exists($user, 'currentAccessToken') && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
            return true;
        }

        return false;
    }
}

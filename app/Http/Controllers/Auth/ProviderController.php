<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class ProviderController extends Controller
{
    //
    public function redirect($provider)
    {
        if ($provider == "github") {
            return Socialite::driver("github")->redirect();
        } elseif ($provider == "google") {
            return Socialite::driver("google")->redirect();
        // } else {
        } elseif ($provider == "facebook") {
            return Socialite::driver("facebook")->redirect();
        } else {
            abort(403, "We dont allow this.");
        }
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            // getting the user details & matching with our db.
            $checkUser = User::where("email", $socialUser->getEmail())->first();
            if ($checkUser) {
                // User with the same email exists
                if ($checkUser->provider !== $provider) {
                    // User exists but with a different provider
                    return redirect("/login")->with('error', 'Use another login method.');
                }
                // User exists with the same provider, log them in
                Auth::login($checkUser);
                return redirect('/dashboard');
            } else {
                $user = User::updateOrCreate([
                    'provider_id' => $socialUser->id,
                    'provider' => $provider
                ], [
                    'name' => $socialUser->name,
                    'email' => $socialUser->email,
                    'provider_token' => $socialUser->token,
                    'password' => bcrypt(Str::random(16)),
                ]);

                Auth::login($user);
                return redirect('/dashboard');
            }
        } catch (\Throwable $e) {
            return redirect('/login')->with('error', $e->getMessage());
        }
    }
}

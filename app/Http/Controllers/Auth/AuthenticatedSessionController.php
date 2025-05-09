<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('profile.index', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

        public function yandex() : RedirectResponse {
        return Socialite::driver('yandex')->redirect();
    }

    public function yandexRedirect() : RedirectResponse {
        $user = Socialite::driver('yandex')->user();
        $existingUser = User::where('email', $user->email)->first();
        $rawPhone = $user->user['default_phone']['number'] ?? null;
        $phone = $rawPhone ? ltrim($rawPhone, '+') : null;
        if (!$existingUser) {
            $newUser = User::create([
                'name' => $user->nickname,
                'email' => $user->email,
                'provider' => 'yandex',
                'password' => Hash::make(Str::random(16)),
                'phone' => $phone,
            ]);

            Auth::login($newUser);
            return redirect(route('profile.index'));
        } else {
            if ($existingUser->provider === 'yandex') {
                Auth::login($existingUser);
                return redirect(route('profile.index'));
            } else {
                return redirect(route('login'))->with('error', 'Используйте логин-пароль для входа');
            }
        }
    }
}

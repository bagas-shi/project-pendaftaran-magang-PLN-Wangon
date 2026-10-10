<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

/**
 * Controller: AuthController
 *
 * Handles all authentication flows:
 * - Standard email/password registration & login
 * - Google OAuth via Laravel Socialite (redirect + callback)
 * - Logout with session invalidation
 *
 * New users registered via any method are assigned the 'peserta' role by default.
 */
class AuthController extends Controller
{
    // ──────────────────────────────────────────────
    // Views
    // ──────────────────────────────────────────────

    /**
     * Show the registration form.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Show the login form.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    // ──────────────────────────────────────────────
    // Standard Email/Password Authentication
    // ──────────────────────────────────────────────

    /**
     * Handle a registration request.
     *
     * Creates a new user with hashed password and assigns the 'peserta' role.
     * Automatically logs the user in after registration.
     */
    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // Auto-hashed via cast
        ]);

        // Assign default candidate role
        $user->assignRole('peserta');

        // Auto-login after registration
        Auth::login($user);

        Log::info('User registered via email', ['user_id' => $user->id, 'email' => $user->email]);

        return redirect()
            ->route('peserta.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    /**
     * Handle a login request.
     *
     * Validates credentials and applies rate-limiting. Regenerates
     * the session on successful login to prevent session fixation.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('email', 'password');
        $remember    = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Email atau password salah.']);
        }

        // Regenerate session to prevent fixation attacks
        $request->session()->regenerate();

        $user = Auth::user();

        Log::info('User logged in via email', ['user_id' => $user->id]);

        // Redirect based on role
        return redirect()->intended($this->redirectPath($user));
    }

    /**
     * Log the user out and invalidate the session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    // ──────────────────────────────────────────────
    // Google OAuth (Laravel Socialite)
    // ──────────────────────────────────────────────

    /**
     * Redirect the user to Google's OAuth consent screen.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google after authentication.
     *
     * If the user already exists (by google_id or email), log them in.
     * Otherwise, create a new account with the 'peserta' role.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            Log::error('Google OAuth callback failed', ['error' => $e->getMessage()]);

            return redirect()
                ->route('login')
                ->withErrors(['google' => 'Gagal login dengan Google. Silakan coba lagi.']);
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->getId())
                     ->orWhere('email', $googleUser->getEmail())
                     ->first();

        if ($user) {
            // Update Google ID and avatar if not set (email-registered user linking Google)
            $user->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $googleUser->getAvatar(),
            ]);
        } else {
            // Create new user from Google data
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'avatar'            => $googleUser->getAvatar(),
                'email_verified_at' => now(), // Google emails are pre-verified
            ]);

            $user->assignRole('peserta');
        }

        Auth::login($user, true);

        Log::info('User logged in via Google OAuth', ['user_id' => $user->id]);

        return redirect()->intended($this->redirectPath($user));
    }

    // ──────────────────────────────────────────────
    // Helpers
    // ──────────────────────────────────────────────

    /**
     * Determine the post-login redirect path based on user role.
     */
    protected function redirectPath(User $user): string
    {
        if ($user->hasRole('super_admin')) {
            return route('superadmin.dashboard');
        }

        if ($user->hasRole('admin')) {
            return route('admin.dashboard');
        }

        // Peserta diarahkan kembali ke landing page setelah login/register
        return route('home');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        if (!Auth::guard('admin')->attempt(
            $request->only('email', 'password'),
            $request->boolean('remember')
        )) {
            RateLimiter::hit($request->throttleKey());

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'The provided credentials do not match our records.']);
        }

        RateLimiter::clear($request->throttleKey());
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}

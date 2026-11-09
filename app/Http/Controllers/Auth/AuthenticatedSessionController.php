<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        $user = $request->user();

        if ($user && $user->isAdmin()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        // Se for cliente comum e a URL pretendida for restrita ao painel admin, limpa a URL pretendida
        $intendedUrl = session()->get('url.intended');
        if ($intendedUrl && (str_contains($intendedUrl, '/dashboard') || str_contains($intendedUrl, '/admin'))) {
            session()->forget('url.intended');
        }

        return redirect()->intended(route('site.chamados', absolute: false));
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
}

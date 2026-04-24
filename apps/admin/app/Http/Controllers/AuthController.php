<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $allowedAdminEmails = $this->normalizedAdminEmails();
            $authenticatedEmail = strtolower(trim((string) optional($request->user())->email));

            if ($allowedAdminEmails !== [] && ! in_array($authenticatedEmail, $allowedAdminEmails, true)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'Credenciales inválidas.'])
                    ->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Credenciales inválidas.'])
            ->onlyInput('email');
    }

    /**
     * @return array<int, string>
     */
    private function normalizedAdminEmails(): array
    {
        return array_values(array_filter(array_map(
            static fn (mixed $email): string => strtolower(trim((string) $email)),
            config('auth.admin_emails', [])
        )));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

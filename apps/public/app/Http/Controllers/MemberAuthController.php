<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class MemberAuthController extends Controller
{
    private const MEMBER_COOKIE_NAME = 'member_token';
    private const RESET_TOKEN_EXPIRY_MINUTES = 60;

    public function showLoginForm(): View
    {
        return view('auth.member-login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.member-register');
    }

    public function login(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'identifier' => ['required', 'string', 'min:3', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'identifier.required' => 'El email o teléfono es obligatorio.',
            'identifier.min' => 'El email o teléfono debe tener al menos 3 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect('/socio/login')
                ->withErrors($validator)
                ->withInput($request->only('identifier'));
        }

        $identifier = trim($request->input('identifier'));
        $password = $request->input('password');

        // Buscar socio por email o teléfono
        $member = Member::where('email', $identifier)->first()
            ?? Member::where('phone', $identifier)->first();

        if (! $member) {
            return redirect('/socio/login')
                ->withErrors(['identifier' => 'No encontramos ningún socio con ese email o teléfono.'])
                ->withInput($request->only('identifier'));
        }

        // Verificar contraseña
        if (! Hash::check($password, $member->password)) {
            return redirect('/socio/login')
                ->withErrors(['password' => 'La contraseña no es correcta.'])
                ->withInput($request->only('identifier'));
        }

        // Regenerar token de sesión
        $token = $member->regenerateToken();

        return redirect()->route('store.home')
            ->withCookie($this->buildMemberCookie($request, $token))
            ->with('success', "¡Bienvenido/a {$member->name}!")
            ->with('member_identified', [
                'member_number' => $member->member_number,
                'name' => $member->name,
            ]);
    }

    public function register(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email'],
            'phone' => ['required', 'string', 'min:6', 'max:20', 'unique:members,phone'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 2 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
            'email.unique' => 'Este email ya está registrado.',
            'phone.required' => 'El teléfono es obligatorio.',
            'phone.unique' => 'Este teléfono ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        if ($validator->fails()) {
            return redirect('/socio/registro')
                ->withErrors($validator)
                ->withInput();
        }

        $member = Member::create([
            'member_number' => Member::max('member_number') + 1,
            'name' => trim($request->input('name')),
            'email' => trim(strtolower($request->input('email'))),
            'phone' => trim($request->input('phone')),
            'password' => $request->input('password'), // Se hashea en el setter del modelo
            'total_orders' => 0,
            'current_level' => 0,
        ]);

        $token = $member->regenerateToken();

        return redirect()->route('store.home')
            ->withCookie($this->buildMemberCookie($request, $token))
            ->with('success', "¡Bienvenido/a {$member->name}! Ya eres socio de PEQ Cakes.")
            ->with('member_identified', [
                'member_number' => $member->member_number,
                'name' => $member->name,
            ]);
    }

    public function showForgotForm(): View
    {
        return view('auth.member-forgot');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email no es válido.',
        ]);

        $email = trim(strtolower($request->input('email')));
        $member = Member::where('email', $email)->first();

        // Siempre mostrar el mismo mensaje (no revelar si existe o no)
        if ($member) {
            $member->sendPasswordResetNotification(self::RESET_TOKEN_EXPIRY_MINUTES);
        }

        return redirect('/socio/login')
            ->with('success', 'Si el email existe en nuestro sistema, le hemos enviado un enlace para restablecer la contraseña.');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->query('token');
        $email = $request->query('email');

        if (! $token || ! $email) {
            return redirect('/socio/olvide-password')
                ->withErrors(['token' => 'Enlace de restablecimiento no válido.']);
        }

        $member = Member::where('email', $email)
            ->where('reset_token', $token)
            ->first();

        if (! $member) {
            return redirect('/socio/olvide-password')
                ->withErrors(['token' => 'Enlace de restablecimiento no válido o expirado.']);
        }

        // Verificar si el token ha expirado (60 minutos)
        if ($member->reset_sent_at && $member->reset_sent_at->addMinutes(self::RESET_TOKEN_EXPIRY_MINUTES)->isPast()) {
            return redirect('/socio/olvide-password')
                ->withErrors(['token' => 'El enlace ha expirado. Solicita uno nuevo.']);
        }

        return view('auth.member-reset', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'token.required' => 'Token requerido.',
            'email.required' => 'El email es obligatorio.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $member = Member::where('email', $request->input('email'))
            ->where('reset_token', $request->input('token'))
            ->first();

        if (! $member) {
            return redirect('/socio/olvide-password')
                ->withErrors(['token' => 'Enlace de restablecimiento no válido.']);
        }

        // Verificar expiración
        if ($member->reset_sent_at && $member->reset_sent_at->addMinutes(self::RESET_TOKEN_EXPIRY_MINUTES)->isPast()) {
            return redirect('/socio/olvide-password')
                ->withErrors(['token' => 'El enlace ha expirado. Solicita uno nuevo.']);
        }

        // Actualizar contraseña
        $member->password = $request->input('password');
        $member->reset_token = null;
        $member->reset_sent_at = null;
        $member->save();

        // Regenerar sesión
        $token = $member->regenerateToken();

        return redirect()->route('store.home')
            ->withCookie($this->buildMemberCookie($request, $token))
            ->with('success', "¡Contraseña actualizada! Ya puedes hacer pedidos.");
    }

    public function logout(Request $request): RedirectResponse
    {
        $member = $request->attributes->get('member');

        if (! $member instanceof Member) {
            $token = $request->cookie('member_token');
            if ($token) {
                $member = Member::where('login_token', $token)->first();
            }
        }

        if ($member instanceof Member) {
            $member->clearToken();
        }

        $cookie = Cookie::forget(
            self::MEMBER_COOKIE_NAME,
            (string) config('session.path', '/'),
            config('session.domain')
        );

        return redirect()->route('store.home')
            ->withCookie($cookie);
    }

    private function buildMemberCookie(Request $request, string $token): \Symfony\Component\HttpFoundation\Cookie
    {
        return Cookie::make(
            self::MEMBER_COOKIE_NAME,
            $token,
            365 * 24 * 60,
            (string) config('session.path', '/'),
            config('session.domain'),
            (bool) ($request->isSecure() || config('session.secure_cookie', false)),
            true,
            false,
            (string) config('session.same_site', 'lax')
        );
    }
}

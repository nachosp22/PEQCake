<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión · PEQ Cakes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #080808;
            --surface: #121212;
            --yellow: #f2b705;
            --yellow-2: #f9cc45;
            --cream: #f7eed9;
            --text: #f4f4f4;
            --muted: #9a9a9a;
            --danger: #ff6b6b;
            --radius: 14px;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: "Manrope", sans-serif;
            min-height: 100vh;
            display: grid;
            place-items: center;
        }
        .card {
            width: min(100% - 1.5rem, 378px);
            background: var(--surface);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow: 0 18px 45px rgba(0,0,0,0.45);
        }
        .card-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .card-logo img {
            height: 126px;
            margin-inline: auto;
        }
        .card-title {
            font-family: "Bebas Neue", sans-serif;
            color: var(--yellow);
            font-size: 1.8rem;
            letter-spacing: 0.04em;
            text-align: center;
            margin-bottom: 0.4rem;
        }
        .card-subtitle {
            color: var(--muted);
            font-size: 0.88rem;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        label {
            display: block;
            color: #c8872a;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.7rem;
            font-weight: 700;
            margin-bottom: 0.4rem;
        }
        .input-wrapper {
            position: relative;
            margin-bottom: 1rem;
        }
        input {
            width: 100%;
            border-radius: var(--radius);
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(0,0,0,0.5);
            color: var(--text);
            font-family: "Manrope", sans-serif;
            font-size: 0.96rem;
            min-height: 50px;
            padding: 0.75rem 0.9rem;
        }
        input::placeholder { color: var(--muted); font-weight: 600; }
        input:focus {
            outline: none;
            border-color: var(--yellow);
            box-shadow: 0 0 0 4px rgba(242,183,5,0.2);
        }
        input.is-invalid { border-color: var(--danger); }
        .btn {
            width: 100%;
            min-height: 52px;
            border-radius: var(--radius);
            border: none;
            background: var(--yellow);
            color: #101010;
            font-family: "Manrope", sans-serif;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
        }
        .btn:hover { background: var(--yellow-2); transform: translateY(-1px); }
        .btn-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: var(--muted);
            text-decoration: none;
            font-size: 0.82rem;
            transition: color 0.2s;
        }
        .btn-link:hover { color: var(--yellow); }
        .errors {
            border: 1px solid rgba(255,107,107,0.4);
            background: rgba(255,107,107,0.08);
            color: #ffd1d1;
            border-radius: var(--radius);
            padding: 0.7rem 0.85rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-logo">
            <img src="{{ asset('img/logosinfondopeq.png') }}" alt="PEQ Cakes">
        </div>
        <h1 class="card-title">Iniciar sesión</h1>
        <p class="card-subtitle">Accede a tu cuenta de socio.</p>

        @if ($errors->any())
            <div class="errors" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('member.login.submit') }}">
            @csrf
            <label for="identifier">Email o teléfono</label>
            <input
                id="identifier"
                name="identifier"
                type="text"
                value="{{ old('identifier') }}"
                required
                minlength="3"
                maxlength="255"
                autocomplete="email tel"
                placeholder="tu@correo.com o 666123456"
                autofocus
            >

            <label for="password" style="margin-top: 0.5rem;">Contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                minlength="8"
                autocomplete="current-password"
                placeholder="Tu contraseña"
            >

            <button class="btn" type="submit" style="margin-top: 0.5rem;">Entrar</button>
        </form>

        <a href="{{ route('member.forgot.form') }}" class="btn-link" style="margin-top: 1rem;">¿Olvidaste tu contraseña?</a>
        <a href="{{ route('store.home') }}" class="btn-link">Volver a la tienda</a>
        
        <div style="text-align:center; margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p style="color: var(--muted); font-size: 0.8rem; margin-bottom: 0.5rem;">¿No tienes cuenta?</p>
            <a href="{{ route('member.register.form') }}" class="btn-link" style="color: var(--yellow); font-weight: 700;">Regístrate aquí</a>
        </div>
    </div>
    @include('components.cookie-consent')
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva contraseña · PEQ Cakes</title>
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
            padding: 1rem;
        }
        .card {
            width: min(100%, 420px);
            background: var(--surface);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 18px 45px rgba(0,0,0,0.45);
        }
        .card-logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .card-logo img {
            height: 56px;
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
            line-height: 1.5;
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
            margin-bottom: 1rem;
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
            transition: background 0.2s, transform 0.15s;
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
        .email-display {
            background: rgba(0,0,0,0.3);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius);
            padding: 0.75rem;
            text-align: center;
            margin-bottom: 1rem;
            color: var(--cream);
            font-size: 0.9rem;
        }
        .password-strength {
            height: 4px;
            border-radius: 2px;
            background: rgba(255,255,255,0.1);
            margin-bottom: 1rem;
            overflow: hidden;
        }
        .password-strength-bar {
            height: 100%;
            width: 0%;
            background: var(--danger);
            transition: width 0.3s, background 0.3s;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-logo">
            <img src="{{ asset('img/logosinfondopeq.png') }}" alt="PEQ Cakes">
        </div>
        <h1 class="card-title">Nueva contraseña</h1>
        <p class="card-subtitle">Introduce tu nueva contraseña. Debe tener al menos 8 caracteres.</p>

        @if ($errors->any())
            <div class="errors" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('member.reset') }}">
            @csrf
            
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="email-display">
                📧 {{ $email }}
            </div>

            <label for="password">Nueva contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                minlength="8"
                autocomplete="new-password"
                placeholder="Mínimo 8 caracteres"
                oninput="checkPasswordStrength(this.value)"
            >
            <div class="password-strength">
                <div class="password-strength-bar" id="strength-bar"></div>
            </div>

            <label for="password_confirmation">Confirmar contraseña</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                minlength="8"
                autocomplete="new-password"
                placeholder="Repite la contraseña"
            >

            <button class="btn" type="submit">Cambiar contraseña</button>
        </form>

        <a href="{{ route('member.login') }}" class="btn-link">Volver al login</a>
    </div>

    <script>
        function checkPasswordStrength(password) {
            const bar = document.getElementById('strength-bar');
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;
            if (/[A-Z]/.test(password)) strength += 25;
            if (/[0-9]/.test(password) || /[^A-Za-z0-9]/.test(password)) strength += 25;
            
            bar.style.width = strength + '%';
            
            if (strength <= 25) bar.style.background = '#ff6b6b';
            else if (strength <= 50) bar.style.background = '#ffaa6b';
            else if (strength <= 75) bar.style.background = '#ffdd6b';
            else bar.style.background = '#7fe89f';
        }
    </script>
    @include('components.cookie-consent')
</body>
</html>

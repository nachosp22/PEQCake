<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidé mi contraseña · PEQ Cakes</title>
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
        .info-box {
            background: rgba(242,183,5,0.08);
            border: 1px solid rgba(242,183,5,0.2);
            border-radius: var(--radius);
            padding: 1rem;
            margin-bottom: 1rem;
            text-align: center;
        }
        .info-box p {
            color: var(--cream);
            font-size: 0.88rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-logo">
            <img src="{{ asset('img/logosinfondopeq.png') }}" alt="PEQ Cakes">
        </div>
        <h1 class="card-title">Contraseña olvidada</h1>
        <p class="card-subtitle">Introduce tu email y te enviaremos un enlace para restablecer tu contraseña.</p>

        @if (session('success'))
            <div class="info-box">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="errors" role="alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('member.forgot') }}">
            @csrf
            <label for="email">Email</label>
            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                placeholder="tu@correo.com"
                autofocus
            >
            <button class="btn" type="submit">Enviar enlace</button>
        </form>

        <a href="{{ route('member.login') }}" class="btn-link">Volver al login</a>
    </div>
    @include('components.cookie-consent')
</body>
</html>

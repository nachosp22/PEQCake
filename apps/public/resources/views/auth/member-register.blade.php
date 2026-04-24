<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Socio · PEQ Cakes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #080808;
            --surface: #121212;
            --yellow: #f2b705;
            --yellow-2: #f9cc45;
            --text: #f4f4f4;
            --muted: #9a9a9a;
            --danger: #ff6b6b;
            --form-placeholder: #8a8a8a;
            --radius-md: 12px;
            --radius-lg: 16px;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
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

        .form-panel {
            width: min(100% - 1.5rem, 414px);
            background: var(--surface);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            box-shadow: var(--shadow);
        }

        .logo-wrapper {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-wrapper img {
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

        .form-group {
            margin-bottom: 1rem;
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
            border-radius: var(--radius-md);
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(0,0,0,0.5);
            color: var(--text);
            font-family: "Manrope", sans-serif;
            font-size: 0.96rem;
            min-height: 50px;
            padding: 0.75rem 0.9rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input::placeholder {
            color: var(--form-placeholder);
            font-weight: 600;
        }

        input:focus {
            outline: none;
            border-color: var(--yellow);
            box-shadow: 0 0 0 4px rgba(242,183,5,0.2);
        }

        input.is-invalid {
            border-color: var(--danger);
        }

        .error-msg {
            color: #ffd1d1;
            font-size: 0.72rem;
            margin-top: 0.2rem;
        }

        .btn {
            width: 100%;
            min-height: 52px;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            border: none;
            border-radius: 14px;
            font-family: "Manrope", sans-serif;
            font-size: 0.82rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            margin-top: 0.5rem;
        }

        .btn-primary {
            background: var(--yellow);
            color: #101010;
            box-shadow: 0 6px 18px rgba(242, 183, 5, 0.3);
        }

        .btn-primary:hover {
            background: var(--yellow-2);
            transform: translateY(-1px);
        }

        .footer-text {
            text-align: center;
            margin-top: 0.6rem;
            color: var(--muted);
            font-size: 0.78rem;
        }

        .footer-text a {
            color: var(--yellow);
            text-decoration: none;
            font-weight: 700;
        }

        .footer-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 700px) {
            body {
                overflow: auto;
                height: auto;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>
    <div class="form-panel">
            <div class="logo-wrapper">
                <a href="/">
                    <img src="{{ asset('img/logosinfondopeq.png') }}" alt="PEQ Cakes">
                </a>
            </div>
            <h1 class="card-title">Crea tu cuenta</h1>
            <p class="card-subtitle">¿Listo para ser socio?</p>

            <form method="POST" action="{{ route('member.register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre completo</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        placeholder="Tu nombre"
                        autocomplete="name"
                        class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('name')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        placeholder="tu@correo.com"
                        autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('email')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <input 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        value="{{ old('phone') }}"
                        placeholder="600 123 456"
                        autocomplete="tel"
                        class="{{ $errors->has('phone') ? 'is-invalid' : '' }}"
                        required
                    >
                    @error('phone')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password"
                        placeholder="Mínimo 8 caracteres"
                        autocomplete="new-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                        required
                        minlength="8"
                    >
                    @error('password')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar contraseña</label>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation"
                        placeholder="Repite la contraseña"
                        autocomplete="new-password"
                        class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                        required
                        minlength="8"
                    >
                    @error('password_confirmation')
                        <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    hacerme socio
                </button>
            </form>

            <p class="footer-text">
                ¿Ya eres socio? <a href="{{ route('member.login') }}">Identifícate aquí</a>
            </p>
        </div>
    </div>
    @include('components.cookie-consent')
</body>
</html>

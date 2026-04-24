<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento · PEQ Cakes</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --black: #0a0a0a;
            --white: #ffffff;
            --gray-100: #f5f5f5;
            --gray-300: #d4d4d4;
            --gray-500: #737373;
        }
        body {
            font-family: 'Manrope', sans-serif;
            background: var(--white);
            color: var(--black);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }
        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2rem, 6vw, 3.5rem);
            letter-spacing: 0.08em;
            color: var(--black);
            margin-bottom: 0.5rem;
            line-height: 1;
        }
        .logo span { color: var(--gray-500); }
        .status {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--gray-500);
            margin-bottom: 3rem;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 2rem;
            opacity: 0.6;
        }
        .title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(2.5rem, 8vw, 4rem);
            letter-spacing: 0.05em;
            color: var(--black);
            margin-bottom: 1rem;
        }
        .message {
            font-size: 0.9rem;
            color: var(--gray-500);
            max-width: 420px;
            line-height: 1.7;
            margin-bottom: 3rem;
        }
        .refresh {
            font-size: 0.75rem;
            color: var(--gray-300);
            margin-top: 2rem;
        }
        .footer {
            position: fixed;
            bottom: 2rem;
            font-size: 0.7rem;
            color: var(--gray-500);
        }
    </style>
</head>
<body>

    <div class="logo">PEQ <span>CAKES</span></div>
    <div class="status">Modo mantenimiento</div>

    <div class="icon">⚙️</div>

    <div class="title">Volvemos pronto</div>

    <p class="message">
        Estamos realizando algunas mejoras para ofrecerte un mejor servicio. El sitio estará disponible en breve.
    </p>

    <p class="refresh">Esta página se actualizará automáticamente</p>

    <div class="footer">PEQ Cakes · {{ date('Y') }}</div>

    {{-- Auto-refresh cada 60 segundos para que cuando quiten artisan down se vea el sitio --}}
    <meta http-equiv="refresh" content="60;url={{ url('/') }}">

</body>
</html>

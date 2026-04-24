<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error · PEQ Cakes</title>
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
            --gray-700: #404040;
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
            margin-bottom: 3rem;
            line-height: 1;
        }
        .logo span { color: var(--gray-500); }
        .code {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(5rem, 20vw, 10rem);
            line-height: 1;
            color: var(--black);
        }
        .title {
            font-size: clamp(1rem, 3vw, 1.3rem);
            font-weight: 600;
            color: var(--gray-700);
            margin-top: 1rem;
            margin-bottom: 2.5rem;
        }
        .message {
            font-size: 0.9rem;
            color: var(--gray-500);
            max-width: 400px;
            line-height: 1.6;
            margin-bottom: 3rem;
        }
        .divider {
            width: 40px;
            height: 2px;
            background: var(--gray-300);
            margin: 0 auto 3rem;
        }
        .cta {
            display: inline-block;
            background: var(--black);
            color: var(--white);
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            padding: 0.9rem 2rem;
            border-radius: 999px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .cta:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
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
    <div class="code">{{ $exception->getStatusCode() }}</div>
    <div class="title">Ha ocurrido un error</div>
    <div class="divider"></div>
    <p class="message">Lo sentimos, algo no ha salido como esperábamos. Por favor, inténtalo de nuevo en unos minutos.</p>
    <a href="{{ url('/') }}" class="cta">Volver al inicio</a>
    <div class="footer">PEQ Cakes · {{ date('Y') }}</div>

</body>
</html>

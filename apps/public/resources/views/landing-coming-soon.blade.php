<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PEQ Cakes · Próximamente</title>
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
            --gray-900: #1a1a1a;
        }

        body {
            font-family: 'Manrope', sans-serif;
            background: var(--white);
            color: var(--black);
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            text-align: center;
        }

        .logo-img {
            max-width: 350px;
            height: auto;
            margin-bottom: 2rem;
        }

        @media (max-width: 767px) {
            .logo-img {
                width: min(250px, 85vw);
            }
        }

        .tagline-texto {
            font-size: clamp(1rem, 2.5vw, 1.3rem);
            font-weight: 500;
            color: var(--gray-500);
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-bottom: 2.5rem;
        }

        .divider {
            width: 40px;
            height: 2px;
            background: var(--gray-300);
            margin: 0 auto 2rem;
        }

        .coming-soon {
            font-size: clamp(2.5rem, 6vw, 3.5rem);
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--black);
        }

        .footer {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.7rem;
            color: var(--gray-500);
            letter-spacing: 0.1em;
        }
    </style>
</head>
<body>

    <img src="{{ asset('img/logobn.jpg') }}" alt="PEQ Cakes" class="logo-img">
    <div class="tagline-texto">Algo especial está en camino</div>

    <div class="divider"></div>

    <div class="coming-soon">Próximamente</div>

    <div class="footer">PEQ Cakes · {{ date('Y') }}</div>

</body>
</html>
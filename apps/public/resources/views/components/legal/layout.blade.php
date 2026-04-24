@props([
    'title',
    'subtitle' => 'Información legal de PEQ Cakes',
])

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} · PEQ Cakes</title>
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #080808;
            --surface: #121212;
            --surface-soft: #171717;
            --yellow: #f2b705;
            --yellow-2: #f9cc45;
            --text: #f4f4f4;
            --muted: #b3b3b3;
            --line: rgba(255, 255, 255, 0.12);
            --radius-lg: 20px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100svh;
            background:
                radial-gradient(circle at 8% 0%, rgba(242, 183, 5, 0.18), transparent 45%),
                radial-gradient(circle at 92% 0%, rgba(249, 204, 69, 0.12), transparent 40%),
                var(--bg);
            color: var(--text);
            font-family: "Manrope", sans-serif;
            line-height: 1.55;
        }

        .wrapper {
            width: min(100% - 1.4rem, 920px);
            margin-inline: auto;
            padding: 1.35rem 0 2.4rem;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            color: var(--yellow-2);
            text-decoration: none;
            font-size: 0.74rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-weight: 800;
            margin-bottom: 1.15rem;
            border: 1px solid rgba(242, 183, 5, 0.36);
            background: rgba(242, 183, 5, 0.08);
            border-radius: 999px;
            padding: 0.5rem 0.95rem;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .back-link:hover {
            transform: translateY(-1px);
            background: rgba(242, 183, 5, 0.16);
        }

        .back-link svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2.2;
        }

        .legal-card {
            border: 1px solid var(--line);
            border-radius: var(--radius-lg);
            background: linear-gradient(180deg, rgba(24, 24, 24, 0.96), rgba(12, 12, 12, 0.98));
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.42);
            padding: 1.3rem;
        }

        .eyebrow {
            font-size: 0.71rem;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--yellow-2);
            margin-bottom: 0.4rem;
        }

        h1 {
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: 0.04em;
            font-size: clamp(2rem, 9vw, 3.35rem);
            line-height: 0.94;
            color: var(--yellow);
            margin-bottom: 0.45rem;
        }

        .subtitle {
            color: var(--muted);
            font-size: 0.9rem;
            margin-bottom: 1.2rem;
        }

        .legal-content {
            display: grid;
            gap: 1rem;
            color: #efefef;
        }

        .legal-content h2 {
            font-size: 1.01rem;
            color: var(--yellow-2);
            letter-spacing: 0.02em;
            margin-bottom: 0.35rem;
        }

        .legal-content p,
        .legal-content li {
            color: #e3e3e3;
            font-size: 0.93rem;
        }

        .legal-content a {
            color: var(--yellow-2);
            text-decoration: none;
        }

        .legal-content a:hover {
            color: var(--yellow);
        }

        .legal-content ul {
            padding-left: 1.05rem;
            display: grid;
            gap: 0.45rem;
        }

        .legal-links {
            margin-top: 1.2rem;
            border-top: 1px solid var(--line);
            padding-top: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.45rem 0.75rem;
        }

        .legal-links a {
            color: rgba(244, 244, 244, 0.8);
            text-decoration: none;
            font-size: 0.76rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: color 0.2s ease;
        }

        .legal-links a:hover {
            color: var(--yellow);
        }

        @media (min-width: 768px) {
            .wrapper {
                padding-top: 1.9rem;
            }

            .legal-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <main class="wrapper">
        <a
            class="back-link"
            href="{{ route('store.home') }}"
            onclick="if (window.history.length > 1) { event.preventDefault(); window.history.back(); }"
            aria-label="Volver a la página anterior"
        >
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M15 18l-6-6 6-6" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
            Volver
        </a>

        <article class="legal-card">
            <p class="eyebrow">PEQ Cakes</p>
            <h1>{{ $title }}</h1>
            <p class="subtitle">{{ $subtitle }}</p>

            <section class="legal-content">
                {{ $slot }}
            </section>

            <nav class="legal-links" aria-label="Otras páginas legales">
                <a href="{{ route('legal.aviso-legal') }}">Aviso legal</a>
                <a href="{{ route('legal.privacidad') }}">Privacidad</a>
                <a href="{{ route('legal.cookies') }}">Cookies</a>
                <a href="{{ route('legal.terminos-condiciones-compra') }}">Términos y condiciones de compra</a>
            </nav>
        </article>
    </main>
    @include('components.cookie-consent')
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarta de queso en Gijon | PEQ Cakes Asturias</title>
    <meta name="description" content="Tartas de queso artesanales en Gijon, Asturias. Descubre PEQ Cakes, haz tu pedido online y recoge tu cheesecake con sabor autentico.">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="theme-color" content="#0a0a0a">
    <link rel="canonical" href="{{ route('home') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_ES">
    <meta property="og:title" content="Tarta de queso en Gijon | PEQ Cakes Asturias">
    <meta property="og:description" content="Cheesecake artesana en Gijon para recoger en tienda. Prueba una de las tartas de queso mas comentadas de Asturias.">
    <meta property="og:url" content="{{ route('home') }}">
    <meta property="og:image" content="{{ asset('img/logosinfondopeq.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="PEQ Cakes | Tarta de queso en Gijon">
    <meta name="twitter:description" content="Haz tu pedido de cheesecake en Gijon y descubre el sabor artesanal de PEQ Cakes en Asturias.">
    <meta name="twitter:image" content="{{ asset('img/logosinfondopeq.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="{{ asset('img/logosinfondopeq.png') }}">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Bakery",
            "name": "PEQ Cakes",
            "url": "{{ url('/') }}",
            "image": "{{ asset('img/logosinfondopeq.png') }}",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "Gijon",
                "addressRegion": "Asturias",
                "addressCountry": "ES"
            }
        }
    </script>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --black: #0a0a0a;
            --white: #ffffff;
            --gray-500: #5f5f5f;
            --line: rgba(0, 0, 0, 0.12);
            --accent: #f2b705;
        }

        body {
            font-family: "Manrope", sans-serif;
            color: var(--black);
            min-height: 100vh;
            background:
                radial-gradient(circle at 20% -10%, rgba(242, 183, 5, 0.16), transparent 40%),
                radial-gradient(circle at 90% 100%, rgba(0, 0, 0, 0.08), transparent 45%),
                var(--white);
            display: grid;
            place-items: center;
            padding: 1.2rem;
        }

        .card {
            width: min(680px, 100%);
            border: 1px solid var(--line);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(6px);
            padding: clamp(1.25rem, 3.5vw, 2.2rem);
            text-align: center;
            box-shadow: 0 22px 48px rgba(0, 0, 0, 0.12);
        }

        .logo {
            width: min(250px, 70vw);
            height: auto;
            margin-bottom: 1rem;
        }

        .eyebrow {
            letter-spacing: 0.17em;
            text-transform: uppercase;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--gray-500);
        }

        h1 {
            margin-top: 0.7rem;
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: 0.05em;
            font-size: clamp(2.1rem, 7vw, 3.1rem);
            line-height: 0.95;
        }

        p {
            margin-top: 0.8rem;
            color: var(--gray-500);
            font-size: clamp(0.95rem, 2.7vw, 1.05rem);
        }

        .cta-grid {
            margin-top: 1.4rem;
            display: grid;
            gap: 0.65rem;
        }

        .btn {
            min-height: 48px;
            border-radius: 999px;
            border: 1px solid transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            font-weight: 800;
            font-size: 0.78rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            padding: 0.6rem 1rem;
        }

        .btn-primary {
            background: var(--black);
            color: var(--white);
        }

        .btn-secondary {
            border-color: var(--line);
            color: var(--black);
            background: rgba(255, 255, 255, 0.7);
        }

        .footer {
            margin-top: 1.15rem;
            font-size: 0.72rem;
            color: var(--gray-500);
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }

        .local-block {
            margin-top: 1rem;
            border-top: 1px solid var(--line);
            padding-top: 0.95rem;
            display: grid;
            gap: 0.6rem;
        }

        .local-block p {
            margin: 0;
            font-size: 0.86rem;
        }

        .legal-links {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.42rem 0.8rem;
        }

        .legal-links a {
            color: var(--gray-500);
            text-decoration: none;
            font-size: 0.68rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        @media (min-width: 700px) {
            .cta-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>
</head>
<body>
    <main class="card" id="contenido-principal">
        <img class="logo" src="{{ asset('img/logosinfondopeq.png') }}" alt="Logo de PEQ Cakes, tartas de queso en Gijon">
        <div class="eyebrow">Cheesecakes artesanas en Gijon</div>
        <h1>Tarta de queso artesanal en Gijon</h1>
        <p>En PEQ Cakes preparamos cheesecake cremosa para recoger en tienda en Gijon. Haz tu pedido online en minutos.</p>

        <div class="cta-grid">
            <a class="btn btn-primary" href="{{ route('store.home') }}">Ir a la tienda</a>
            <a class="btn btn-secondary" href="{{ route('member.login') }}">Area socios</a>
        </div>

        <section class="local-block" aria-labelledby="local-title">
            <h2 id="local-title" class="eyebrow" style="margin:0;">Gijon, Asturias</h2>
            <p>Recogida local en Calle la Playa, 7. Si quieres probar una de las mejores tartas de queso en Asturias, te esperamos en PEQ Cakes.</p>
            <p><a class="btn btn-secondary" href="{{ route('store.home') }}#tienda">Como llegar y horarios</a></p>
            <div class="legal-links" aria-label="Enlaces legales">
                <a href="{{ route('legal.aviso-legal') }}">Aviso legal</a>
                <a href="{{ route('legal.privacidad') }}">Privacidad</a>
                <a href="{{ route('legal.cookies') }}">Cookies</a>
            </div>
        </section>

        <div class="footer">PEQ Cakes · {{ date('Y') }}</div>
    </main>

    @include('components.cookie-consent')
</body>
</html>

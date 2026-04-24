<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarta de queso en Gijon | Tienda PEQ Cakes Asturias</title>
    <meta name="description" content="Pide tu tarta de queso en Gijon con PEQ Cakes. Cheesecake artesanal en Asturias para recoger en tienda con sabores irresistibles.">
    <meta name="robots" content="index,follow,max-image-preview:large">
    <meta name="theme-color" content="#080808">
    <link rel="canonical" href="{{ route('store.home') }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="es_ES">
    <meta property="og:title" content="Tarta de queso en Gijon | Tienda PEQ Cakes Asturias">
    <meta property="og:description" content="Cheesecake cremosa hecha en Gijon. Reserva online y recoge tu tarta de queso artesanal en Asturias.">
    <meta property="og:url" content="{{ route('store.home') }}">
    <meta property="og:image" content="{{ asset('video/fotofondo.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="PEQ Cakes | Cheesecake Gijon">
    <meta name="twitter:description" content="Haz tu pedido de tarta de queso en Gijon y recogelo en PEQ Cakes.">
    <meta name="twitter:image" content="{{ asset('video/fotofondo.jpg') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="preload" as="image" href="{{ asset('video/fotofondo.jpg') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Bakery",
            "name": "PEQ Cakes",
            "url": "{{ url('/') }}",
            "image": "{{ asset('video/fotofondo.jpg') }}",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Calle la Playa, 7",
                "addressLocality": "Gijon",
                "addressRegion": "Asturias",
                "addressCountry": "ES"
            },
            "sameAs": [
                "https://www.instagram.com/peqcakes/",
                "https://www.tiktok.com/@peqcakes"
            ]
        }
    </script>
    <style>
        :root {
            --bg: #080808;
            --surface: #121212;
            --yellow: #f2b705;
            --yellow-2: #f9cc45;
            --cream: #f7eed9;
            --text: #f4f4f4;
            --muted: #9a9a9a;
            --line: rgba(255,255,255,0.12);
            --danger: #ff6b6b;
            --form-placeholder: #8a8a8a;
            --form-placeholder-size: 0.96rem;
            --form-placeholder-weight: 600;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 26px;
            --shadow: 0 18px 45px rgba(0, 0, 0, 0.45);
            --cake-card-radius: 24px;
            --cake-card-shadow: 0 14px 34px rgba(0, 0, 0, 0.3);
            --cake-card-body-pad: 0.9rem 0.95rem;
            --cake-card-body-gap: 0.5rem;
            --cake-card-media-width-desktop: 44%;
            --cake-card-title-size: 1.42rem;
            --cake-card-desc-size: 0.87rem;
            --cake-card-desc-lines: 3;
            --cake-card-min-height-desktop: 198px;
            --cake-card-min-height-mobile: 126px;
            --allergen-icon-bg: rgba(242,183,5,0.14);
            --allergen-icon-border: rgba(242,183,5,0.44);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--bg);
            color: var(--text);
            font-family: "Manrope", sans-serif;
            line-height: 1.45;
            overflow-x: hidden;
        }

        .skip-link {
            position: absolute;
            left: 0.6rem;
            top: -3rem;
            z-index: 80;
            background: var(--yellow);
            color: #101010;
            text-decoration: none;
            font-size: 0.78rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 0.55rem 0.8rem;
            border-radius: 999px;
        }

        .skip-link:focus {
            top: 0.65rem;
        }

        .wrapper {
            width: min(100% - 1.25rem, 1100px);
            margin-inline: auto;
        }

        .hero {
            position: relative;
            min-height: 100svh;
            display: grid;
            place-items: center;
            overflow: hidden;
            padding: 1rem 0 5.75rem;
        }
        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }
        .hero-bg video,
        .hero-bg img {
            width: auto;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .hero-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                linear-gradient(rgba(0, 0, 0, 0.64), rgba(0, 0, 0, 0.64)),
                linear-gradient(180deg, rgba(8,8,8,0) 35%, rgba(8,8,8,0.94) 100%);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            width: min(100% - 1rem, 740px);
            text-align: center;
            display: grid;
            gap: 0.85rem;
        }
        .hero-logo-img {
            width: auto;
            height: clamp(145px, 20vw, 170px);
            margin-inline: auto;
            filter: drop-shadow(0 5px 20px rgba(0,0,0,0.56));
        }
        .hero-headline {
            font-family: "Bebas Neue", sans-serif;
            color: var(--yellow);
            font-size: clamp(2.35rem, 13vw, 6.4rem);
            letter-spacing: 0.04em;
            line-height: 0.9;
            text-wrap: balance;
            text-shadow: 0 4px 24px rgba(0, 0, 0, 0.5);
        }
        .hero-body {
            color: rgba(247, 238, 217, 0.92);
            font-size: clamp(0.93rem, 4vw, 1.1rem);
            max-width: 38ch;
            margin-inline: auto;
        }
        .hero-ctas {
            display: grid;
            gap: 0.6rem;
            width: 100%;
            max-width: 460px;
            margin-inline: auto;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.82rem 1.4rem;
            border: 1.5px solid transparent;
            border-radius: 999px;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            font-family: inherit;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
            width: 100%;
            white-space: normal;
            min-height: 48px;
        }

        .hero-ctas .btn {
            width: 100%;
            min-height: 56px;
            padding-inline: 1.1rem;
            line-height: 1.2;
            text-align: center;
            align-content: center;
            white-space: nowrap;
            text-wrap: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: clamp(0.72rem, 2.8vw, 0.8rem);
            letter-spacing: clamp(0.03em, 0.25vw, 0.08em);
        }

        @media (min-width: 430px) {
            .btn {
                width: auto;
                min-width: 160px;
            }
            .btn-members-mobile {
                display: none;
            }
        }
        .btn:focus-visible {
            outline: 3px solid rgba(242, 183, 5, 0.4);
            outline-offset: 2px;
        }
        .btn-primary {
            background: var(--yellow);
            color: #101010;
            border: none;
            box-shadow: 0 10px 24px rgba(242, 183, 5, 0.34);
        }
        .btn-secondary {
            background: rgba(255,255,255,0.06);
            color: var(--text);
            border-color: rgba(255,255,255,0.26);
            backdrop-filter: blur(6px);
        }

        section { padding: 3.5rem 0; }
        .eyebrow {
            color: #c8872a;
            text-transform: uppercase;
            letter-spacing: 0.18em;
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 0.65rem;
        }
        .stitle {
            font-family: "Bebas Neue", sans-serif;
            color: var(--yellow);
            letter-spacing: 0.045em;
            line-height: 0.92;
            font-size: clamp(2rem, 10vw, 4.7rem);
            margin-bottom: 0.8rem;
        }
        .sbody {
            max-width: 53ch;
            color: var(--muted);
            margin-bottom: 1.8rem;
            font-size: clamp(0.93rem, 3.9vw, 1.02rem);
        }

        .pgrid {
            display: grid;
            gap: 0.8rem;
            grid-template-columns: 1fr;
        }
        .pcard {
            background: linear-gradient(165deg, #171717, #0a0a0a);
            border: 1px solid rgba(255,255,255,0.14);
            border-radius: var(--cake-card-radius);
            overflow: hidden;
            box-shadow: var(--cake-card-shadow);
            display: grid;
            grid-template-columns: minmax(0, var(--cake-card-media-width-desktop)) minmax(0, 1fr);
            align-items: stretch;
            min-height: var(--cake-card-min-height-desktop);
        }
        .pcard[data-open-cake-modal] {
            cursor: pointer;
        }
        .pcard figure {
            position: relative;
            overflow: hidden;
            height: 100%;
            min-height: var(--cake-card-min-height-desktop);
            background: rgba(0, 0, 0, 0.32);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .pcard img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }
        .pcard-media-fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            background: linear-gradient(145deg, rgba(242,183,5,0.12), rgba(0,0,0,0.32));
            color: rgba(247,238,217,0.7);
            font: 700 0.75rem "Manrope", sans-serif;
            letter-spacing: 0.1em;
            text-transform: uppercase;
        }
        .pcard-body {
            padding: var(--cake-card-body-pad);
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: var(--cake-card-body-gap);
            min-width: 0;
        }
        .pcard-name {
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: 0.04em;
            font-size: var(--cake-card-title-size);
            line-height: 0.95;
            color: var(--yellow);
        }
        .pcard-desc {
            color: #d3d3d3;
            font-size: var(--cake-card-desc-size);
            line-height: 1.35;
            max-width: 100%;
            overflow-wrap: anywhere;
            text-wrap: pretty;
        }
        .pcard-detail {
            margin-top: auto;
            align-self: center;
            text-align: center;
            color: var(--yellow);
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .cake-modal {
            position: fixed;
            inset: 0;
            z-index: 40;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(0,0,0,0.72);
        }
        .cake-modal.open {
            display: flex;
        }
        .cake-modal-dialog {
            width: min(100%, 980px);
            max-height: min(92vh, 860px);
            overflow-y: auto;
            border-radius: var(--radius-xl);
            border: 1px solid rgba(255,255,255,0.14);
            background: linear-gradient(165deg, #171717, #0a0a0a);
            box-shadow: var(--shadow);
            padding: 1.05rem;
            display: grid;
            gap: 1rem;
        }
        .cake-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.8rem;
        }
        .cake-modal-head .eyebrow {
            font-size: 0.8rem;
        }
        .cake-modal-close {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid rgba(239,68,68,0.55);
            background: rgba(239,68,68,0.14);
            color: #ef4444;
            cursor: pointer;
            font-size: 1.05rem;
            line-height: 1;
        }
        .cake-modal-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        .cake-modal-content {
            display: grid;
            gap: 0.8rem;
            align-content: start;
            justify-items: stretch;
        }
        .cake-modal-media {
            border-radius: var(--radius-lg);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.1);
            min-height: 190px;
        }
        .cake-modal-media img {
            width: 100%;
            height: 100%;
            min-height: 190px;
            object-fit: cover;
            display: block;
        }
        .cake-modal-name {
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: 0.04em;
            font-size: clamp(1.8rem, 6vw, 2.6rem);
            color: var(--yellow);
            line-height: 0.95;
        }
        .cake-modal-desc {
            color: #d3d3d3;
            font-size: 0.93rem;
        }
        .cake-modal-prices {
            display: grid;
            gap: 0.3rem;
            width: 100%;
        }
        .cake-modal-price-line {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            padding: 0.4rem 0.62rem;
            background: rgba(255,255,255,0.03);
        }
        .cake-modal-price-label {
            color: #c8872a;
            text-transform: uppercase;
            font-size: 0.69rem;
            letter-spacing: 0.08em;
            font-weight: 800;
        }
        .cake-modal-price-value {
            color: var(--yellow);
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: 0.05em;
            font-size: 1.15rem;
        }
        .cake-modal-allergens {
            display: grid;
            gap: 0.5rem;
        }
        .cake-modal-allergens-title {
            color: #c8872a;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            font-weight: 800;
        }
        .allergen-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .allergen-chip {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 999px;
            background: rgba(255,255,255,0.06);
            width: 2rem;
            height: 2rem;
            padding: 0;
        }
        .allergen-chip-empty {
            width: auto;
            min-height: 2rem;
            padding: 0.16rem 0.55rem 0.16rem 0.16rem;
            gap: 0.4rem;
            justify-content: flex-start;
            border: 1px solid rgba(255,255,255,0.14);
        }
        .allergen-chip-empty .allergen-icon {
            width: 1.68rem;
            height: 1.68rem;
            flex: 0 0 1.68rem;
            font-size: 0.62rem;
            letter-spacing: 0.06em;
        }
        .allergen-chip-empty-text {
            color: #d9d9d9;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            line-height: 1.2;
        }
        .allergen-icon {
            width: 100%;
            height: 100%;
            border-radius: 999px;
            background: rgba(0,0,0,0.32);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.72rem;
            font-weight: 800;
            color: var(--yellow);
            text-transform: uppercase;
            overflow: hidden;
        }
        .allergen-icon-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .allergen-icon-fallback {
            display: none;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            align-items: center;
            justify-content: center;
            font-size: 0.66rem;
            letter-spacing: 0.04em;
        }
        @media (max-width: 560px) {
            .allergen-list {
                gap: 0.45rem;
            }
        }
        .cake-modal-actions {
            display: flex;
            gap: 0.6rem;
            flex-wrap: wrap;
        }
        .cake-modal-order-controls {
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            gap: 0.6rem;
            justify-content: center;
        }
        .cake-modal-qty {
            width: 100%;
            max-width: 180px;
        }
        .cake-modal-qty .qty-step {
            grid-template-columns: 38px 1fr 38px;
            gap: 0.3rem;
        }
        .cake-modal-qty .qty-sb,
        .cake-modal-qty .qty-num {
            min-height: 40px;
        }
        .cake-modal-size-pills {
            display: grid;
            gap: 0.45rem;
            grid-template-columns: 1fr 1fr;
            width: 100%;
        }
        .cake-modal-size-pill {
            min-height: 46px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--radius-md);
            background: rgba(0,0,0,0.55);
            color: var(--muted);
            font: 700 0.78rem "Manrope", sans-serif;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            cursor: pointer;
            padding-inline: 0.55rem;
        }
        .cake-modal-size-pill.active {
            border-color: var(--yellow);
            color: var(--yellow);
            background: rgba(242,183,5,0.12);
        }
        .cake-modal-actions .btn {
            width: auto;
            min-width: 180px;
        }
        #cake-modal-add-btn {
            width: auto;
            min-width: 180px;
            min-height: 38px;
            padding: 0.34rem 1.05rem;
            font-size: 0.74rem;
            letter-spacing: 0.06em;
            box-shadow: 0 6px 16px rgba(242, 183, 5, 0.26);
        }

        .form-box {
            border: 1px solid var(--line);
            border-radius: var(--radius-xl);
            background: rgba(255,255,255,0.02);
            padding: 1rem;
            box-shadow: var(--shadow);
        }
        .fgrid {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        .ffull { grid-column: 1 / -1; }
        label {
            display: block;
            color: #c8872a;
            text-transform: uppercase;
            letter-spacing: 0.14em;
            font-size: 0.72rem;
            font-weight: 700;
            margin-bottom: 0.42rem;
        }
        input,
        select,
        textarea {
            width: 100%;
            border-radius: var(--radius-md);
            border: 1px solid rgba(255,255,255,0.2);
            background: #000000;
            color: #ffffff;
            font: inherit;
            font-size: 0.96rem;
            min-height: 48px;
            padding: 0.7rem 0.82rem;
        }
        textarea {
            resize: vertical;
            min-height: 96px;
        }
        input::placeholder,
        textarea::placeholder,
        .date-input-wrap .delivery-date-preview::placeholder {
            color: var(--form-placeholder);
            opacity: 1;
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
            letter-spacing: 0;
        }
        input::-webkit-input-placeholder,
        textarea::-webkit-input-placeholder,
        .date-input-wrap .delivery-date-preview::-webkit-input-placeholder {
            color: var(--form-placeholder);
            opacity: 1;
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
            letter-spacing: 0;
        }
        input::-moz-placeholder,
        textarea::-moz-placeholder,
        .date-input-wrap .delivery-date-preview::-moz-placeholder {
            color: var(--form-placeholder);
            opacity: 1;
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
            letter-spacing: 0;
        }
        input:-ms-input-placeholder,
        textarea:-ms-input-placeholder,
        .date-input-wrap .delivery-date-preview:-ms-input-placeholder {
            color: var(--form-placeholder);
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
            letter-spacing: 0;
        }
        input::-ms-input-placeholder,
        textarea::-ms-input-placeholder,
        .date-input-wrap .delivery-date-preview::-ms-input-placeholder {
            color: var(--form-placeholder);
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
            letter-spacing: 0;
        }
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--yellow);
            box-shadow: 0 0 0 4px rgba(242,183,5,0.24);
        }

        .date-input-wrap {
            position: relative;
        }

        .date-input-wrap input[type="date"],
        .date-input-wrap input[type="text"] {
            cursor: pointer;
        }

        .date-input-wrap .delivery-date-preview[readonly] {
            opacity: 1;
        }

        .date-input-wrap .delivery-date-preview[readonly].is-empty {
            color: var(--form-placeholder) !important;
            -webkit-text-fill-color: var(--form-placeholder);
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
        }

        .date-input-wrap .delivery-date-preview[readonly]:not(.is-empty) {
            color: var(--text) !important;
            -webkit-text-fill-color: var(--text);
        }

        #b-cake.is-empty {
            color: var(--form-placeholder);
            font-family: "Manrope", sans-serif;
            font-size: var(--form-placeholder-size);
            font-weight: var(--form-placeholder-weight);
            letter-spacing: 0;
        }

        .date-help {
            margin-top: 0.42rem;
            color: var(--muted);
            font-size: 0.78rem;
        }

        .date-help.error {
            color: #ffd1d1;
        }

        .flatpickr-calendar {
            background: #ffffff;
            border: 1px solid #d9d9d9;
            border-radius: 12px;
            box-shadow: 0 14px 28px rgba(0,0,0,0.18);
        }
        .flatpickr-months,
        .flatpickr-weekdays,
        .flatpickr-days,
        .dayContainer {
            background: #ffffff;
        }
        .flatpickr-months .flatpickr-month {
            min-height: 54px;
            padding: 0.55rem 2rem 0.75rem;
        }
        .flatpickr-current-month {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.55rem;
            line-height: 1.25;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            font-weight: 700;
            padding: 0 0.3rem;
        }
        .flatpickr-current-month input.cur-year {
            font-weight: 700;
            min-width: 4.2ch;
            padding-left: 0.15rem;
        }
        .flatpickr-weekdays {
            padding: 0.15rem 0 0.25rem;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year,
        .flatpickr-weekday,
        .flatpickr-day,
        .flatpickr-prev-month,
        .flatpickr-next-month {
            color: #111111;
            fill: #111111;
        }
        .flatpickr-weekday {
            font-weight: 700;
        }
        .flatpickr-day:hover,
        .flatpickr-day:focus {
            background: #f2f2f2;
            border-color: #cfcfcf;
        }
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected:hover,
        .flatpickr-day.startRange:hover,
        .flatpickr-day.endRange:hover {
            background: #111111;
            color: #ffffff;
            border-color: #111111;
        }
        .flatpickr-day.today {
            border-color: #8f8f8f;
        }
        .flatpickr-day.flatpickr-disabled,
        .flatpickr-day.prevMonthDay.flatpickr-disabled,
        .flatpickr-day.nextMonthDay.flatpickr-disabled {
            color: rgba(17,17,17,0.36);
        }
        .flatpickr-day.fp-day-blocked,
        .flatpickr-day.fp-day-blocked.flatpickr-disabled,
        .flatpickr-day.fp-day-blocked.prevMonthDay,
        .flatpickr-day.fp-day-blocked.nextMonthDay {
            color: #ff6b6b !important;
            text-decoration: line-through;
            text-decoration-thickness: 2px;
            text-decoration-color: rgba(255,107,107,0.92);
            opacity: 0.95;
        }
        .flatpickr-day.fp-day-blocked:hover,
        .flatpickr-day.fp-day-blocked:focus {
            background: rgba(255,107,107,0.14);
            border-color: rgba(255,107,107,0.28);
        }

        .builder-wrap {
            display: grid;
            gap: 1rem;
            margin-top: 1rem;
        }
        .builder-row {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        .size-head {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 0.5rem;
            margin-bottom: 0.42rem;
        }
        .size-head label {
            margin-bottom: 0;
        }
        .selected-unit-price {
            color: var(--yellow);
            font-size: 0.88rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }
        .size-pills {
            display: grid;
            gap: 0.45rem;
            grid-template-columns: 1fr 1fr;
        }
        .size-pill {
            min-height: 48px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: var(--radius-md);
            background: rgba(0,0,0,0.55);
            color: var(--muted);
            font: 700 0.82rem "Manrope", sans-serif;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            cursor: pointer;
            padding-inline: 0.6rem;
        }
        .size-pill.active {
            border-color: var(--yellow);
            color: var(--yellow);
            background: rgba(242,183,5,0.12);
        }

        .qty-step {
            display: grid;
            grid-template-columns: 42px 1fr 42px;
            align-items: center;
            gap: 0.35rem;
        }
        .qty-sb {
            min-height: 42px;
            border: 1px solid rgba(242,183,5,0.34);
            background: rgba(242,183,5,0.1);
            border-radius: 11px;
            color: var(--yellow);
            font-size: 1.2rem;
            font-weight: 800;
            cursor: pointer;
        }
        .qty-num {
            min-height: 42px;
            text-align: center;
            font-weight: 700;
            -moz-appearance: textfield;
        }
        .qty-num::-webkit-inner-spin-button,
        .qty-num::-webkit-outer-spin-button { -webkit-appearance: none; }

        .btn-add-ticket {
            min-height: 48px;
            width: 100%;
            border: 1.5px solid var(--yellow);
            border-radius: 999px;
            background: rgba(242,183,5,0.1);
            color: var(--yellow);
            text-transform: uppercase;
            font: 800 0.78rem "Manrope", sans-serif;
            letter-spacing: 0.09em;
            cursor: pointer;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            padding-inline: 0.8rem;
        }

        .ticket-area {
            border: 1.5px dashed rgba(242,183,5,0.35);
            border-radius: var(--radius-lg);
            padding: 0.7rem;
            background: rgba(0,0,0,0.3);
            display: grid;
            gap: 0.6rem;
        }
        .ticket-empty {
            color: var(--muted);
            text-align: center;
            font-size: 0.87rem;
            padding: 0.55rem 0;
        }
        .ticket-line {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.55rem;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.04);
            padding: 0.68rem;
        }
        .ticket-main {
            min-width: 0;
            display: grid;
            gap: 0.4rem;
        }
        .tl-name {
            font-size: 0.92rem;
            font-weight: 700;
            overflow-wrap: anywhere;
        }
        .ticket-meta {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            flex-wrap: wrap;
        }
        .tl-badge,
        .tl-qty,
        .tl-price {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            min-height: 26px;
            padding-inline: 0.48rem;
            font-size: 0.72rem;
            font-weight: 800;
            letter-spacing: 0.05em;
        }
        .tl-badge { border: 1px solid rgba(255,255,255,0.16); color: #c8872a; }
        .tl-qty { background: rgba(242,183,5,0.12); color: var(--yellow); }
        .tl-price { background: rgba(255,255,255,0.08); color: #f6d88e; }
        .tl-del {
            width: 34px;
            height: 34px;
            border: 1px solid rgba(255,107,107,0.36);
            background: rgba(255,107,107,0.1);
            border-radius: 10px;
            color: var(--danger);
            cursor: pointer;
            justify-self: end;
        }

        .ticket-summary {
            border-top: 1px solid rgba(255,255,255,0.12);
            padding-top: 0.56rem;
            display: grid;
            gap: 0.4rem;
        }
        .ticket-count { color: var(--muted); font-size: 0.8rem; }
        .ticket-total {
            font-family: "Bebas Neue", sans-serif;
            color: var(--yellow);
            letter-spacing: 0.05em;
            font-size: 1.45rem;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9rem;
        }
        .summary-label { color: var(--muted); }
        .summary-value { font-weight: 700; color: var(--text); }
        .summary-discount .summary-value { color: #7fe89f; }
        .summary-total .summary-value {
            font-family: "Bebas Neue", sans-serif;
            letter-spacing: 0.05em;
            color: var(--yellow);
            font-size: 1.4rem;
        }

        .discount-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 0.55rem;
            align-items: end;
        }
        .btn-apply {
            min-height: 48px;
            border-radius: var(--radius-md);
            padding-inline: 1rem;
            width: auto;
        }
        .discount-feedback {
            margin-top: 0.5rem;
            border-radius: 10px;
            font-size: 0.82rem;
            padding: 0.55rem 0.65rem;
            display: none;
        }
        .discount-feedback.show { display: block; }
        .discount-feedback.success {
            border: 1px solid rgba(67, 199, 116, 0.45);
            color: #b8ffd1;
            background: rgba(67, 199, 116, 0.12);
        }
        .discount-feedback.error {
            border: 1px solid rgba(255,107,107,0.42);
            color: #ffd1d1;
            background: rgba(255,107,107,0.08);
        }

        .btn-submit {
            width: 100%;
            min-height: 56px;
            border-radius: 14px;
            font-size: 0.92rem;
            letter-spacing: 0.09em;
            border: none;
        }

        .errors {
            border: 1px solid rgba(255,107,107,0.42);
            background: rgba(255,107,107,0.08);
            color: #ffd1d1;
            border-radius: 14px;
            padding: 0.75rem 0.9rem;
            margin-bottom: 1rem;
        }
        .errors ul {
            padding-left: 1rem;
            display: grid;
            gap: 0.25rem;
        }
        .footer {
            border-top: 1px solid rgba(255,255,255,0.08);
            text-align: center;
            color: #666;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.11em;
            padding: 1.7rem 0 5.8rem;
        }
        .footer-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.9rem;
            margin-bottom: 0.85rem;
        }
        .footer-social a {
            width: 36px;
            height: 36px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.2);
            color: var(--text);
            background: rgba(255,255,255,0.02);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }
        .footer-social a:hover {
            border-color: rgba(242,183,5,0.6);
            color: var(--yellow);
            transform: translateY(-1px);
        }
        .footer-social svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
        }
        .footer-legal {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 0.4rem 0.9rem;
            margin-bottom: 0.95rem;
            font-size: 0.65rem;
        }
        .footer-legal a {
            color: rgba(244,244,244,0.72);
            text-decoration: none;
            letter-spacing: 0.08em;
            transition: color 0.2s ease;
        }
        .footer-legal a:hover {
            color: var(--yellow);
        }
        .store-section {
            border-top: 1px solid rgba(255,255,255,0.08);
            background: linear-gradient(180deg, rgba(18,18,18,0.7), rgba(8,8,8,1));
        }
        .store-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        .store-map {
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: var(--radius-lg);
            overflow: hidden;
            min-height: 280px;
            box-shadow: var(--shadow);
        }
        .store-map iframe {
            width: 100%;
            height: 100%;
            min-height: 280px;
            border: 0;
            display: block;
        }
        .store-info {
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: var(--radius-lg);
            background: rgba(255,255,255,0.03);
            padding: 1rem;
            display: grid;
            gap: 1rem;
        }
        .store-block h3 {
            font-family: "Bebas Neue", sans-serif;
            color: var(--yellow);
            font-size: 1.5rem;
            letter-spacing: 0.05em;
            margin-bottom: 0.45rem;
        }
        .store-block ul {
            list-style: none;
            display: grid;
            gap: 0.35rem;
        }
        .store-block li,
        .store-block p {
            color: var(--muted);
            font-size: 0.94rem;
        }
        .store-block a {
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
        }
        .store-block a:hover {
            color: var(--yellow);
        }
        .social-links {
            list-style: none;
            display: grid;
            gap: 0.42rem;
        }
        .social-links a {
            color: var(--text);
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.04em;
        }
        .toast-stack {
            position: fixed;
            inset: auto 0 0 0;
            z-index: 50;
            display: grid;
            gap: 0.55rem;
            pointer-events: none;
            padding: 0 0.75rem calc(env(safe-area-inset-bottom, 0px) + 0.7rem);
        }
        .toast-item {
            border-radius: 14px;
            font-weight: 800;
            text-align: center;
            padding: 0.74rem 1rem;
            box-shadow: var(--shadow);
            border: 1px solid rgba(242,183,5,0.45);
            background: rgba(8, 8, 8, 0.96);
            color: var(--cream);
            width: 100%;
            opacity: 0;
            transform: translateY(8px);
            animation: toast-enter 220ms ease forwards;
        }
        .toast-item.success {
            border-color: rgba(67, 199, 116, 0.48);
            background: rgba(8, 25, 14, 0.96);
            color: #cbffe0;
        }
        .toast-item.error {
            border-color: rgba(255,107,107,0.5);
            background: rgba(40, 10, 10, 0.96);
            color: #ffd1d1;
        }
        .toast-item.leaving {
            animation: toast-leave 180ms ease forwards;
        }
        @keyframes toast-enter {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        @keyframes toast-leave {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(8px);
            }
        }

        .mobile-cta {
            position: fixed;
            bottom: 0.5rem;
            left: 0.5rem;
            right: 0.5rem;
            z-index: 25;
            display: none;
        }
        .mobile-cta .btn {
            min-height: 54px;
            border-radius: 14px;
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.44);
        }

        @media (min-width: 375px) {
            .wrapper { width: min(100% - 1.5rem, 1100px); }
            .hero-content { gap: 1rem; }
        }

        @media (min-width: 390px) {
            .btn { font-size: 0.82rem; }
            .ticket-line { grid-template-columns: 1fr auto; }
        }

        @media (max-width: 767px) {
            :root {
                --cake-card-body-pad: 0.58rem 0.7rem;
                --cake-card-body-gap: 0.3rem;
                --cake-card-media-width-desktop: 112px;
                --cake-card-title-size: 1.1rem;
                --cake-card-desc-size: 0.74rem;
                --cake-card-desc-lines: 2;
                --cake-card-min-height-mobile: 122px;
            }

            .cake-modal {
                align-items: flex-start;
                padding: 0.75rem;
                overflow-y: auto;
            }

            .cake-modal-dialog {
                width: 100%;
                max-height: min(calc(100vh - 1.5rem), calc(100dvh - 1.5rem));
                overflow-y: auto;
            }

            .cake-modal-head {
                position: sticky;
                top: -1.05rem;
                z-index: 6;
                left: 0;
                right: 0;
                width: calc(100% + 2.1rem);
                margin: -1.05rem -1.05rem 0;
                padding: 1.2rem 1.05rem 0.35rem;
                box-sizing: border-box;
                background: linear-gradient(165deg, #171717, #101010);
            }

            .cake-modal-close {
                flex-shrink: 0;
            }

            .pgrid {
                gap: 0.6rem;
            }

            .pcard {
                grid-template-columns: minmax(0, var(--cake-card-media-width-desktop)) minmax(0, 1fr);
                min-height: var(--cake-card-min-height-mobile);
                align-items: stretch;
            }

            .pcard figure {
                min-height: var(--cake-card-min-height-mobile);
            }

            .pcard img {
                object-fit: cover;
                object-position: center;
            }

            .pcard-body {
                justify-content: center;
            }

            .pcard-detail {
                font-size: 0.72rem;
            }

            #member-fab {
                display: none !important;
            }
        }

        @media (min-width: 430px) {
            :root {
                --cake-card-desc-lines: 3;
            }

            .hero-ctas {
                grid-template-columns: 1fr;
                align-items: stretch;
            }
            .builder-row { grid-template-columns: 1fr 1fr; }
            .builder-row > :last-child { grid-column: 1 / -1; }
        }

        @media (min-width: 768px) {
            .hero-bg video,
            .hero-bg img {
                width: 100%;
                object-position: center;
            }
            .hero {
                padding-bottom: 3rem;
            }
            .hero-ctas {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                max-width: 700px;
            }
            .hero-ctas .btn {
                width: 100%;
                min-height: 58px;
                height: 58px;
                padding-inline: 1.2rem;
            }

            section { padding: 5rem 0; }
            .pgrid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 1.1rem;
            }
            .fgrid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .builder-row {
                grid-template-columns: 1.2fr 0.9fr 1fr;
                align-items: end;
            }
            .builder-row > :last-child { grid-column: auto; }
            .ticket-line {
                grid-template-columns: 1fr auto;
                align-items: center;
            }
            .store-grid {
                grid-template-columns: 1.2fr 1fr;
                align-items: stretch;
            }
            .footer { padding-bottom: 2.4rem; }
            .toast-stack { padding: 0 1.1rem calc(env(safe-area-inset-bottom, 0px) + 1rem); }

            .cake-modal-dialog {
                padding: 1.25rem;
            }
            .cake-modal-grid {
                grid-template-columns: minmax(0, 0.92fr) minmax(0, 1.28fr);
                align-items: start;
            }
            .cake-modal-content > * {
                width: 100%;
            }
            .cake-modal-actions {
                align-items: flex-end;
            }
            .cake-modal-order-controls {
                justify-content: flex-start;
                align-items: flex-end;
                flex-wrap: nowrap;
            }
            .cake-modal-qty {
                width: auto;
                min-width: 180px;
            }
            .cake-modal-media,
            .cake-modal-media img {
                min-height: 260px;
            }
            #cake-modal-add-btn {
                height: 40px;
                min-height: 40px;
                max-height: 40px;
                padding: 0.28rem 1.05rem;
                font-size: 0.74rem;
                line-height: 1;
                align-self: flex-end;
                margin-bottom: 2px;
            }
        }

        @media (min-width: 980px) {
            .wrapper {
                width: min(100% - 1.75rem, 1240px);
            }
            .pgrid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .pcard-body {
                justify-content: flex-start;
            }
            .pcard-detail {
                margin-top: auto;
            }
        }

        @media (min-width: 1280px) {
            .pgrid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        }

        @media (hover: hover) and (pointer: fine) {
            .btn:hover { transform: translateY(-2px); }
            .btn-primary:hover { background: var(--yellow-2); }
            .btn-secondary:hover { border-color: var(--yellow); color: var(--yellow); }
            .btn-add-ticket:hover { background: rgba(242,183,5,0.2); }
            .pcard { transition: transform 0.28s ease, border-color 0.28s ease; }
            .pcard:hover {
                transform: translateY(-6px);
                border-color: rgba(242,183,5,0.6);
            }
            .pcard-detail {
                color: var(--yellow-2);
            }
        }
    </style>
</head>
<body>
    <a class="skip-link" href="#contenido-principal">Saltar al contenido</a>

    <header class="hero" id="inicio">
        <div class="hero-bg">
            <img src="{{ asset('video/fotofondo.jpg') }}" alt="Tarta de queso artesanal de PEQ Cakes en Gijon">
        </div>

        <div class="hero-content">
            <img class="hero-logo-img" src="{{ asset('img/logosinfondopeq.png') }}" alt="Logo PEQ Cakes">
            <h1 class="hero-headline">LA CREMOSIDAD<br>NO SE NEGOCIA</h1>
            <p class="hero-body">Cheesecake artesanal en Gijon para quienes buscan una tarta de queso cremosa, intensa y hecha a diario en Asturias.</p>

            <div class="hero-ctas">
                <a class="btn btn-primary btn-members-mobile" href="{{ route('member.login') }}">Area PEQLOVER</a>
                <a class="btn btn-secondary" href="#productos">TARTAS</a>
                <a class="btn btn-secondary" href="#tienda">VISITANOS</a>
                <a class="btn btn-primary" href="#pedido">PIDE LA TUYA</a>
            </div>
        </div>
    </header>

    <main id="contenido-principal">

    <section id="productos">
        <div class="wrapper">
            <p class="eyebrow">Cheesecake artesanal en Asturias</p>
            <h2 class="stitle">NUESTRAS TENTACIONES</h2>
            <p class="sbody">Cada tarta de queso de PEQ Cakes se hornea en Gijon con producto fresco y textura cremosa. Si buscas una cheesecake en Gijon con sabor artesanal, aqui tienes nuestros sabores mas pedidos.</p>

            @php
                $cardDescriptionLimit = 157;
            @endphp
            <div class="pgrid">
                @forelse ($cakes as $cake)
                    <article class="pcard" data-open-cake-modal data-cake-id="{{ $cake->id }}" role="button" tabindex="0" aria-label="Abrir detalle de {{ $cake->name }}">
                        <figure>
                            <img src="{{ $cake->image_url ? (str_starts_with($cake->image_url, 'http') ? $cake->image_url : asset('img/' . $cake->image_url)) : 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?auto=format&fit=crop&w=900&q=80' }}" alt="{{ $cake->name }} de PEQ Cakes, tarta de queso en Gijon" loading="lazy" decoding="async">
                        </figure>
                        <div class="pcard-body">
                            <h3 class="pcard-name">{{ $cake->name }}</h3>
                            <p class="pcard-desc">{{ \Illuminate\Support\Str::limit(trim((string) ($cake->description ?: 'Cheesecake artesana de PEQ Cakes.')), $cardDescriptionLimit, '...') }}</p>
                            <span class="pcard-detail">Ver detalle</span>
                        </div>
                    </article>
                @empty
                    <article class="pcard">
                        <div class="pcard-body">
                            <h3 class="pcard-name">Próximamente</h3>
                        </div>
                    </article>
                @endforelse
            </div>
        </div>
    </section>

    <div id="cake-detail-modal" class="cake-modal" aria-hidden="true">
        <div class="cake-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="cake-modal-name">
            <div class="cake-modal-head">
                <p class="eyebrow" style="margin-bottom:0;">Detalle tarta</p>
                <button type="button" class="cake-modal-close" id="cake-modal-close" aria-label="Cerrar detalle de tarta">✕</button>
            </div>

            <div class="cake-modal-grid">
                <div class="cake-modal-media">
                    <img id="cake-modal-image" src="" alt="">
                </div>

                <div class="cake-modal-content">
                    <h3 id="cake-modal-name" class="cake-modal-name"></h3>
                    <p id="cake-modal-description" class="cake-modal-desc"></p>

                    <div class="cake-modal-prices">
                        <div class="cake-modal-price-line">
                            <span class="cake-modal-price-label">Tamano BITE</span>
                            <span class="cake-modal-price-value" id="cake-modal-price-s"></span>
                        </div>
                        <div class="cake-modal-price-line">
                            <span class="cake-modal-price-label">Tamano PARTY</span>
                            <span class="cake-modal-price-value" id="cake-modal-price-l"></span>
                        </div>
                    </div>

                    <div class="cake-modal-allergens">
                        <p class="cake-modal-allergens-title">Alergenos</p>
                        <div id="cake-modal-allergens" class="allergen-list"></div>
                    </div>

                    <div class="cake-modal-actions">
                        <div class="cake-modal-size-pills" role="group" aria-label="Seleccionar tamaño de tarta">
                            <button type="button" class="cake-modal-size-pill active" data-modal-size="BITE">BITE</button>
                            <button type="button" class="cake-modal-size-pill" data-modal-size="PARTY">PARTY</button>
                        </div>
                        <div class="cake-modal-order-controls">
                            <div class="cake-modal-qty">
                                <label for="cake-modal-qty">Cantidad</label>
                                <div class="qty-step">
                                    <button type="button" class="qty-sb" onclick="bQty(-1, 'cake-modal-qty')" aria-label="Restar cantidad del modal">-</button>
                                    <input id="cake-modal-qty" class="qty-num" type="number" min="1" max="99" value="1">
                                    <button type="button" class="qty-sb" onclick="bQty(1, 'cake-modal-qty')" aria-label="Sumar cantidad del modal">+</button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="cake-modal-add-btn">Añadir al pedido</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section id="pedido">
        <div class="wrapper">
            <p class="eyebrow">Pide la tuya</p>
            <h2 class="stitle">NO TE QUEDES SIN TU PEQ</h2>
            <p class="sbody">Haz tu pedido online de tarta de queso en Gijon y programa la recogida en tienda. Rapido, claro y con disponibilidad real de sabores.</p>

            @if(isset($member) && $member)
                {{-- Socio card --}}
                <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; background:rgba(242,183,5,0.1); border:1px solid rgba(242,183,5,0.35); border-radius:var(--radius-lg); padding:0.7rem 1rem; margin-bottom:1rem; flex-wrap:wrap;">
                    <div style="display:flex; align-items:center; gap:0.65rem;">
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:1.3rem; height:1.3rem;">
                            <svg width="18" height="18" viewBox="0 0 24 24" role="img" aria-label="Comecocos" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="12" cy="12" r="10" fill="var(--yellow,#f2b705)"/>
                                <path d="M12 12L20.6 7A10 10 0 0 1 20.6 17Z" fill="#101010"/>
                                <circle cx="10.1" cy="8.4" r="1.15" fill="#101010"/>
                            </svg>
                        </span>
                        <div>
                            <span style="font-weight:700; color:var(--cream,#f7eed9);">PEQLOVER {{ $member->formattedMemberNumber }}</span>
                            @if($member->name)
                                <span style="color:var(--muted,#9a9a9a); font-size:0.85rem;"> · {{ $member->name }}</span>
                            @endif
                            @if($member->total_orders > 0)
                            <span style="color:var(--muted,#9a9a9a); font-size:0.82rem;"> · {{ $member->total_orders }} pedidos · Nivel {{ $member->current_level }}/10</span>
                            @else
                            <span style="color:var(--muted,#9a9a9a); font-size:0.82rem;"> · Sin pedidos</span>
                            @endif
                        </div>
                    </div>
                    <button type="button" onclick="openMemberModal()" style="background:var(--yellow,#f2b705); color:#101010; border:none; border-radius:999px; padding:0.4rem 1rem; font-size:0.72rem; font-weight:800; letter-spacing:0.07em; text-transform:uppercase; cursor:pointer;">
                        Ver tarjeta
                    </button>
                </div>
            @else
                <div style="background:rgba(0,0,0,0.35); border:1px solid rgba(242,183,5,0.2); border-radius:var(--radius-lg); padding:0.75rem 1rem; margin-bottom:1rem; display:flex; align-items:center; justify-content:space-between; gap:0.75rem;">
                    <span style="color:var(--muted,#9a9a9a); font-size:0.82rem; line-height:1.3;">
                        Inicia sesión y si aún no eres <span style="font-weight:700; color:var(--yellow,#f2b705);">PEQLOVER</span>, ¿A qué estás esperando?<br><span style="font-size:0.72rem; color:var(--muted,#9a9a9a); opacity:0.7;">Acumula puntos con cada pedido y obtén premios increíbles.</span>
                    </span>
                    <a href="{{ route('member.login') }}" style="
                        flex-shrink:0;
                        background:linear-gradient(135deg, #f2b705, #f9cc45);
                        color:#101010;
                        font-family:'Manrope',sans-serif;
                        font-weight:800;
                        font-size:0.78rem;
                        letter-spacing:0.04em;
                        text-decoration:none;
                        padding:0.5rem 1rem;
                        border-radius:999px;
                        box-shadow:0 4px 16px rgba(242,183,5,0.35);
                        transition:transform 0.2s ease, box-shadow 0.2s ease;
                    "
                    onmouseover="this.style.transform='scale(1.04)'"
                    onmouseout="this.style.transform='scale(1)'">
                        Identifícate →
                    </a>
                </div>
            @endif

            <div class="form-box">
                @if ($errors->any())
                    <div class="errors" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="order-form" method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <div class="fgrid">
                        <div>
                            <label for="customer_name">Tu nombre</label>
                            <input id="customer_name" name="customer_name" value="{{ old('customer_name') ?: ($member->name ?? '') }}" @readonly(isset($member) && $member) required autocomplete="name" placeholder="¿Cómo te llamamos?">
                        </div>
                        <div>
                            <label for="customer_phone">Teléfono</label>
                            <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone') ?: ($member->phone ?? '') }}" @readonly(isset($member) && $member) required inputmode="tel" autocomplete="tel" placeholder="Para avisarte cuando esté lista">
                        </div>
                        <div class="ffull">
                            <label for="customer_email">Email</label>
                            <input id="customer_email" type="email" name="customer_email" value="{{ old('customer_email') ?: ($member->email ?? '') }}" @readonly(isset($member) && $member) required autocomplete="email" placeholder="tu@correo.com">
                        </div>
                        <div class="ffull">
                            <label for="delivery_date">Fecha de recogida</label>
                            @php
                                $cutoffTimeLabel = $agendaSetting->resolveCutoffTime();
                                $beforeCutoffDays = (int) $agendaSetting->min_days_before_cutoff;
                                $afterCutoffDays = (int) $agendaSetting->min_days_after_cutoff;
                                $deliveryDateHelpText = 'Pedidos antes de las '.$cutoffTimeLabel.': minimo '.$beforeCutoffDays.' dia(s). Despues de esa hora: minimo '.$afterCutoffDays.' dia(s).';
                            @endphp
                            <div class="date-input-wrap" id="delivery-date-wrap">
                                <input id="delivery_date" type="text" name="delivery_date" value="{{ old('delivery_date') }}" data-min-date="{{ $minimumPickupDate }}" placeholder="dd/mm/aaaa" autocomplete="off" inputmode="none" required>
                            </div>
                            <p id="delivery-date-help" data-default-message="{{ $deliveryDateHelpText }}" class="date-help">{{ $deliveryDateHelpText }}</p>
                        </div>
                        <div class="ffull">
                            <label for="notes">Notas para cocina (opcional)</label>
                            <input id="notes" name="notes" value="{{ old('notes') }}" maxlength="1000" placeholder="Escribenos algo si lo necesitas">
                        </div>
                    </div>

                    <div class="builder-wrap">
                        <div>
                            <label for="b-cake">Elige tus tentaciones</label>
                            <select id="b-cake">
                                <option value="">Elige tu PEQ ...</option>
                                @foreach ($cakes as $cake)
                                    <option value="{{ $cake->id }}" data-price-s="{{ (float) $cake->priceForSize('BITE') }}" data-price-l="{{ (float) $cake->priceForSize('PARTY') }}" data-name="{{ $cake->name }}">
                                        {{ $cake->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="builder-row">
                            <div>
                                <div class="size-head">
                                    <label>Tamaño</label>
                                </div>
                                <div class="size-pills">
                                    <button type="button" class="size-pill active" data-size="BITE" onclick="selectSize(this)">BITE - €—</button>
                                    <button type="button" class="size-pill" data-size="PARTY" onclick="selectSize(this)">PARTY - €—</button>
                                </div>
                            </div>

                            <div>
                                <label for="b-qty">Cantidad</label>
                                <div class="qty-step">
                                    <button type="button" class="qty-sb" onclick="bQty(-1)" aria-label="Restar">−</button>
                                    <input id="b-qty" class="qty-num" type="number" min="1" max="99" value="1">
                                    <button type="button" class="qty-sb" onclick="bQty(1)" aria-label="Sumar">+</button>
                                </div>
                            </div>

                            <div>
                                <label style="visibility:hidden;">Añadir</label>
                                <button type="button" class="btn-add-ticket" onclick="addToTicket()">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round">
                                        <line x1="12" y1="5" x2="12" y2="19"/>
                                        <line x1="5" y1="12" x2="19" y2="12"/>
                                    </svg>
                                    Añadir al ticket
                                </button>
                            </div>
                        </div>

                        <div id="ticket-area" class="ticket-area">
                            <p class="ticket-empty" id="ticket-empty">Tu ticket está vacío. Añade tu primera tarta.</p>
                            <div id="ticket-lines"></div>
                            <div id="ticket-summary" class="ticket-summary" style="display:none;">
                                <span class="ticket-count" id="ticket-count"></span>
                                <div class="summary-row">
                                    <span class="summary-label">Subtotal</span>
                                    <span class="summary-value" id="ticket-subtotal">€0.00</span>
                                </div>
                                <div class="summary-row summary-discount">
                                    <span class="summary-label">Descuento</span>
                                    <span class="summary-value" id="ticket-discount">−€0.00</span>
                                </div>
                                <div class="summary-row summary-total">
                                    <span class="summary-label">Total</span>
                                    <span class="summary-value" id="ticket-total">€0.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="ffull">
                            <label for="discount_code">Código de descuento (opcional)</label>
                            <div class="discount-row">
                                <input id="discount_code" name="discount_code" value="{{ old('discount_code') }}" maxlength="64" placeholder="¿Tienes un código promocional?">
                                <button type="button" id="apply-discount-btn" class="btn btn-secondary btn-apply">Aplicar</button>
                            </div>
                            <div id="discount-feedback" class="discount-feedback" aria-live="polite"></div>
                        </div>

                        <button class="btn btn-primary btn-submit" type="submit" onclick="validateTicket(event)">Enviar pedido a cocina</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section id="tienda" class="store-section">
        <div class="wrapper">
            <p class="eyebrow">Tienda fisica en Gijon</p>
            <h2 class="stitle">VEN A VISITARNOS</h2>
            <p class="sbody">Estamos en Calle la Playa, 7, Gijon (Asturias). Recoge aqui tu cheesecake recien hecha o consulta disponibilidad para tu proximo pedido.</p>

            <div class="store-grid">
                <div class="store-map">
                    <iframe
                        title="Ubicacion de PEQ Cakes en Google Maps"
                        src="https://www.google.com/maps?q=43.5395794,-5.6541611&z=17&output=embed"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                </div>

                <div class="store-info">
                    <div class="store-block">
                        <h3>Horario</h3>
                        <ul>
                            <li>Lunes a jueves: 10:00 - 14:00 y 17:00 - 20:00</li>
                            <li>Viernes y sabado: 10:00 - 20:30</li>
                            <li>Domingo: cerrado</li>
                        </ul>
                    </div>

                    <div class="store-block">
                        <h3>Información adicional</h3>
                        <p>Las recogidas se realizan en tienda. Recomendamos reservar con al menos 24 horas de antelacion para asegurar disponibilidad de sabores y horarios.</p>
                    </div>

                </div>
            </div>
        </div>
    </section>

    </main>

    <footer class="footer">
        <div class="footer-social" aria-label="Redes sociales de PEQ Cakes">
            <a href="https://www.tiktok.com/@peqcakes" target="_blank" rel="noopener noreferrer" aria-label="TikTok de PEQ Cakes">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M14 4.2c1 1.4 2.3 2.2 4 2.4v3.1c-1.4-.1-2.8-.5-4-1.1v6.2a5.8 5.8 0 1 1-5-5.8v3.2a2.6 2.6 0 1 0 1.8 2.6V3h3.2z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </a>
            <a href="https://www.instagram.com/peqcakes/" target="_blank" rel="noopener noreferrer" aria-label="Instagram de PEQ Cakes">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3.5" y="3.5" width="17" height="17" rx="5" ry="5" stroke-width="1.8"></rect>
                    <circle cx="12" cy="12" r="3.8" stroke-width="1.8"></circle>
                    <circle cx="17.4" cy="6.6" r="0.9" fill="currentColor" stroke="none"></circle>
                </svg>
            </a>
        </div>
        <div class="footer-legal" aria-label="Enlaces legales de PEQ Cakes">
            <a href="{{ route('legal.aviso-legal') }}">Aviso legal</a>
            <a href="{{ route('legal.privacidad') }}">Privacidad</a>
            <a href="{{ route('legal.cookies') }}">Cookies</a>
            <a href="{{ route('legal.terminos-condiciones-compra') }}">Términos y condiciones de compra</a>
        </div>
        PEQ Cakes • Gijón • 2026
    </footer>

    {{-- Socio FAB (cambia según estado de autenticación) --}}
    @if(isset($member) && $member)
        @include('components.member-modal')
        <button
            type="button"
            id="member-fab"
            onclick="openMemberModal()"
            style="
                position:fixed;
                bottom:1.2rem;
                right:1.2rem;
                z-index:25;
                display:flex;
                align-items:center;
                gap:0.5rem;
                padding:0.7rem 1.15rem;
                border-radius:999px;
                background:linear-gradient(135deg, #f2b705, #f9cc45);
                border:none;
                color:#101010;
                font-family:'Manrope',sans-serif;
                font-size:0.78rem;
                font-weight:800;
                letter-spacing:0.04em;
                text-decoration:none;
                box-shadow:0 8px 28px rgba(242,183,5,0.45);
                transition:transform 0.2s ease, box-shadow 0.2s ease;
                cursor:pointer;
            "
            onmouseover="this.style.transform='scale(1.06) translateY(-2px)'; this.style.boxShadow='0 14px 36px rgba(242,183,5,0.6)'"
            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 28px rgba(242,183,5,0.45)'"
            title="Tarjeta PEQLOVER #{{ str_pad($member->member_number, 4, '0', STR_PAD_LEFT) }}"
            aria-label="Ver tarjeta de socio"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#101010" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="5" width="20" height="14" rx="2"/>
                <path d="M2 10h20"/>
            </svg>
            PEQLOVER #{{ str_pad($member->member_number, 4, '0', STR_PAD_LEFT) }}
        </button>
    @else
        <a
            href="{{ route('member.login') }}"
            id="member-fab"
            style="
                position:fixed;
                bottom:1.2rem;
                right:1.2rem;
                z-index:25;
                display:flex;
                align-items:center;
                gap:0.5rem;
                padding:0.7rem 1.15rem;
                border-radius:999px;
                background:linear-gradient(135deg, #f2b705, #f9cc45);
                border:none;
                color:#101010;
                font-family:'Manrope',sans-serif;
                font-size:0.78rem;
                font-weight:800;
                letter-spacing:0.04em;
                text-decoration:none;
                box-shadow:0 8px 28px rgba(242,183,5,0.45);
                transition:transform 0.2s ease, box-shadow 0.2s ease;
            "
            onmouseover="this.style.transform='scale(1.06) translateY(-2px)'; this.style.boxShadow='0 14px 36px rgba(242,183,5,0.6)'"
            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 28px rgba(242,183,5,0.45)'"
            title="Área de Socios"
            aria-label="Acceder al área de socios"
        >
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#101010" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Área PEQLOVER
        </a>
    @endif

    <div id="toast-stack" class="toast-stack" aria-live="polite" aria-atomic="false"></div>

    @php
        $cakesPayload = $cakes->map(function ($cake) {
            $resolvedImage = $cake->image_url
                ? (str_starts_with($cake->image_url, 'http') ? $cake->image_url : asset('img/' . $cake->image_url))
                : 'https://images.unsplash.com/photo-1624353365286-3f8d62daad51?auto=format&fit=crop&w=900&q=80';

            return [
                'id' => $cake->id,
                'name' => $cake->name,
                'description' => $cake->description,
                'image_url' => $resolvedImage,
                'price_s' => (float) $cake->priceForSize('BITE'),
                'price_l' => (float) $cake->priceForSize('PARTY'),
                'allergens' => $cake->activeAllergens(),
            ];
        })->values();
    @endphp
    <script id="cakes-json" type="application/json">@json($cakesPayload)</script>
    <script id="old-pedido-json" type="application/json">@json(old('pedido', []))</script>
    <script id="blocked-dates-json" type="application/json">@json(($blockedDates ?? collect())->values())</script>
    <script id="blocked-weekdays-json" type="application/json">@json(($blockedWeekdays ?? collect())->values())</script>
    <script id="flash-success-json" type="application/json">@json(session('success'))</script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/es.js"></script>
    <script>
        const CAKES = JSON.parse(document.getElementById('cakes-json')?.textContent || '[]');
        const oldItems = JSON.parse(document.getElementById('old-pedido-json')?.textContent || '[]');
        const BLOCKED_DATES = new Set(JSON.parse(document.getElementById('blocked-dates-json')?.textContent || '[]'));
        const BLOCKED_WEEKDAYS = new Set(JSON.parse(document.getElementById('blocked-weekdays-json')?.textContent || '[]').map((value) => Number(value)));
        const flashSuccessMessage = JSON.parse(document.getElementById('flash-success-json')?.textContent || 'null');
        const DISCOUNT_PREVIEW_URL = "{{ route('discounts.preview') }}";
        const CSRF_TOKEN = "{{ csrf_token() }}";
        const ALLERGEN_ICON_FILES = {
            allergen_milk: 'milk.svg',
            allergen_eggs: 'egg.svg',
            allergen_gluten: 'gluten.svg',
            allergen_nuts: 'fsecos.svg',
            allergen_soy: 'soja.svg',
            allergen_sulfites: 'sulfitos.svg',
        };

        let ticketItems = [];
        let ticketIdx = 0;
        let appliedDiscount = null;
        let modalScrollY = 0;
        let cakeModalOpen = false;

        function showToast(message, tone = 'success', timeoutMs = 3200) {
            const stack = document.getElementById('toast-stack');
            if (!stack || !message) return;

            const toast = document.createElement('div');
            toast.className = `toast-item ${tone === 'error' ? 'error' : 'success'}`;
            toast.setAttribute('role', 'status');
            toast.textContent = String(message);
            stack.appendChild(toast);

            window.setTimeout(() => {
                toast.classList.add('leaving');
                window.setTimeout(() => toast.remove(), 200);
            }, Math.max(1200, Number(timeoutMs) || 3200));
        }

        function lockBackgroundScroll() {
            if (cakeModalOpen) return;
            modalScrollY = window.scrollY || window.pageYOffset || 0;
            document.documentElement.style.overflow = 'hidden';
            document.body.style.overflow = 'hidden';
            document.body.style.position = 'fixed';
            document.body.style.top = `-${modalScrollY}px`;
            document.body.style.left = '0';
            document.body.style.right = '0';
            document.body.style.width = '100%';
            cakeModalOpen = true;
        }

        function unlockBackgroundScroll() {
            if (!cakeModalOpen) return;
            document.documentElement.style.overflow = '';
            document.body.style.overflow = '';
            document.body.style.position = '';
            document.body.style.top = '';
            document.body.style.left = '';
            document.body.style.right = '';
            document.body.style.width = '';
            window.scrollTo(0, modalScrollY);
            cakeModalOpen = false;
        }

        function openCakeDetailModal(cakeId) {
            const modal = document.getElementById('cake-detail-modal');
            if (!modal) return;

            const cake = CAKES.find((entry) => Number(entry.id) === Number(cakeId));
            if (!cake) return;

            const image = document.getElementById('cake-modal-image');
            const name = document.getElementById('cake-modal-name');
            const description = document.getElementById('cake-modal-description');
            const priceS = document.getElementById('cake-modal-price-s');
            const priceL = document.getElementById('cake-modal-price-l');
            const allergensWrap = document.getElementById('cake-modal-allergens');
            const addBtn = document.getElementById('cake-modal-add-btn');
            const modalQtyInput = document.getElementById('cake-modal-qty');

            document.querySelectorAll('.cake-modal-size-pill').forEach((pill) => {
                pill.classList.toggle('active', pill.dataset.modalSize === 'BITE');
            });
            if (modalQtyInput) modalQtyInput.value = '1';

            if (image) {
                image.src = String(cake.image_url || '');
                image.alt = `Imagen de ${cake.name || 'tarta'}`;
            }
            if (name) name.textContent = String(cake.name || 'Tarta');
            if (description) {
                const detailDescription = String(cake.description || '').trim();
                description.textContent = detailDescription || 'Sin descripcion adicional disponible.';
            }
            if (priceS) priceS.textContent = `€${Number(cake.price_s || 0).toFixed(2)}`;
            if (priceL) priceL.textContent = `€${Number(cake.price_l || 0).toFixed(2)}`;

            if (allergensWrap) {
                const allergens = Array.isArray(cake.allergens) ? cake.allergens : [];
                if (allergens.length === 0) {
                    allergensWrap.innerHTML = '<span class="allergen-chip allergen-chip-empty" aria-label="Sin alergenos marcados"><span class="allergen-icon">OK</span><span class="allergen-chip-empty-text">Sin alergenos marcados</span></span>';
                } else {
                    allergensWrap.innerHTML = allergens.map((allergen) => {
                        const field = allergen?.field || '';
                        const label = allergen?.label || 'Alergeno';
                        const iconFile = ALLERGEN_ICON_FILES[field] || '';
                        const fallbackCode = String(label).slice(0, 2).toUpperCase();
                        if (!iconFile) {
                            return `<span class="allergen-chip" title="${escapeHtml(label)}" aria-label="${escapeHtml(label)}"><span class="allergen-icon">${escapeHtml(fallbackCode)}</span></span>`;
                        }

                        const iconSrc = `/img/alergenos/${encodeURIComponent(iconFile)}`;

                        return `<span class="allergen-chip" title="${escapeHtml(label)}" aria-label="${escapeHtml(label)}"><span class="allergen-icon"><img class="allergen-icon-img" src="${iconSrc}" alt="${escapeHtml(label)}" loading="lazy" decoding="async" onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';"><span class="allergen-icon-fallback">${escapeHtml(fallbackCode)}</span></span></span>`;
                    }).join('');
                }
            }

            if (addBtn) {
                addBtn.onclick = () => {
                    const selectedSize = selectedModalSize();
                    const selectedQuantity = selectedModalQuantity();
                    const added = addCakeToTicket(cake.id, selectedSize, selectedQuantity);
                    if (added) {
                        showToast('Tarta añadida con éxito.');
                    }

                    const cakeSelect = document.getElementById('b-cake');
                    if (cakeSelect) {
                        cakeSelect.value = String(cake.id);
                        updateSelectedUnitPrice();
                    }

                    const matchingSizePill = document.querySelector(`.size-pill[data-size="${selectedSize}"]`);
                    if (matchingSizePill) {
                        selectSize(matchingSizePill);
                    }

                    revealTicketArea({ scroll: false });
                };
            }

            modal.classList.add('open');
            modal.setAttribute('aria-hidden', 'false');
            lockBackgroundScroll();
        }

        function closeCakeDetailModal() {
            const modal = document.getElementById('cake-detail-modal');
            if (!modal) return;
            modal.classList.remove('open');
            modal.setAttribute('aria-hidden', 'true');
            unlockBackgroundScroll();
        }

        function setupCakeDetailModal() {
            document.querySelectorAll('[data-open-cake-modal]').forEach((trigger) => {
                trigger.addEventListener('click', () => {
                    openCakeDetailModal(trigger.dataset.cakeId);
                });

                trigger.addEventListener('keydown', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        openCakeDetailModal(trigger.dataset.cakeId);
                    }
                });
            });

            document.getElementById('cake-modal-close')?.addEventListener('click', closeCakeDetailModal);
            document.getElementById('cake-detail-modal')?.addEventListener('click', (event) => {
                if (event.target?.id === 'cake-detail-modal') {
                    closeCakeDetailModal();
                }
            });

            window.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeCakeDetailModal();
                }
            });

            document.querySelectorAll('.cake-modal-size-pill').forEach((pill) => {
                pill.addEventListener('click', () => {
                    document.querySelectorAll('.cake-modal-size-pill').forEach((node) => node.classList.remove('active'));
                    pill.classList.add('active');
                });
            });
        }

        function selectSize(el) {
            document.querySelectorAll('.size-pill').forEach((pill) => pill.classList.remove('active'));
            el.classList.add('active');
            updateSelectedUnitPrice();
        }

        function bQty(delta, inputId = 'b-qty') {
            const input = document.getElementById(inputId);
            if (!input) return;
            const current = parseInt(input.value, 10) || 1;
            input.value = Math.max(1, Math.min(99, current + delta));
        }

        function addToTicket() {
            const cakeSelect = document.getElementById('b-cake');
            const cakeId = parseInt(cakeSelect.value, 10);

            if (!cakeId) {
                cakeSelect.focus();
                cakeSelect.style.borderColor = 'rgba(255,107,107,0.9)';
                setTimeout(() => {
                    cakeSelect.style.borderColor = '';
                }, 1200);
                return;
            }

            const quantity = Math.max(1, Math.min(99, parseInt(document.getElementById('b-qty').value, 10) || 1));
            const size = document.querySelector('.size-pill.active')?.dataset.size || 'BITE';
            const added = addCakeToTicket(cakeId, size, quantity);
            if (added) {
                showToast('Tarta añadida con éxito.');
            }
            document.getElementById('b-qty').value = 1;
        }

        function addCakeToTicket(cakeId, size = 'BITE', quantity = 1) {
            const parsedCakeId = parseInt(cakeId, 10);
            const cake = CAKES.find((entry) => Number(entry.id) === parsedCakeId);
            if (!cake) return false;

            ticketItems.push({
                idx: ticketIdx++,
                cakeId: parsedCakeId,
                name: cake.name,
                priceS: Number(cake.price_s || 0),
                priceL: Number(cake.price_l || 0),
                size: normalizeSizeAlias(size),
                quantity: Math.max(1, Math.min(99, parseInt(quantity, 10) || 1)),
            });

            clearAppliedDiscount('El ticket cambió. Vuelve a aplicar el código para recalcular el descuento.', 'error');
            renderTicket();
            syncHiddens();
            return true;
        }

        function selectedModalSize() {
            return document.querySelector('.cake-modal-size-pill.active')?.dataset.modalSize || 'BITE';
        }

        function selectedModalQuantity() {
            const input = document.getElementById('cake-modal-qty');
            return Math.max(1, Math.min(99, parseInt(input?.value, 10) || 1));
        }

        function revealTicketArea(options = {}) {
            const ticket = document.getElementById('ticket-area');
            if (!ticket) return;
            if (options.scroll !== false) {
                ticket.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            ticket.style.borderColor = 'rgba(242,183,5,0.9)';
            ticket.style.borderStyle = 'solid';
            setTimeout(() => {
                ticket.style.borderColor = '';
                ticket.style.borderStyle = '';
            }, 1000);
        }

        function updateSelectedUnitPrice() {
            const priceNode = document.getElementById('selected-unit-price');
            const cakeSelect = document.getElementById('b-cake');
            const selectedSize = document.querySelector('.size-pill.active')?.dataset.size || 'BITE';
            if (!cakeSelect) return;

            cakeSelect.classList.toggle('is-empty', !cakeSelect.value);

            const selectedOption = cakeSelect.options[cakeSelect.selectedIndex];
            const bitePill = document.querySelector('.size-pill[data-size="BITE"]');
            const partyPill = document.querySelector('.size-pill[data-size="PARTY"]');
            if (!selectedOption || !selectedOption.value) {
                if (priceNode) priceNode.textContent = 'Precio: —';
                if (bitePill) bitePill.textContent = 'BITE - €—';
                if (partyPill) partyPill.textContent = 'PARTY - €—';
                return;
            }

            const priceS = Number(selectedOption.dataset.priceS || 0);
            const priceL = Number(selectedOption.dataset.priceL || 0);
            if (bitePill) bitePill.textContent = `BITE - €${priceS.toFixed(2)}`;
            if (partyPill) partyPill.textContent = `PARTY - €${priceL.toFixed(2)}`;
            const unitPrice = selectedSize === 'PARTY' ? priceL : priceS;

            if (priceNode) {
                priceNode.textContent = `Precio ${selectedSize}: €${unitPrice.toFixed(2)}`;
            }
        }

        function removeItem(idx) {
            ticketItems = ticketItems.filter((item) => item.idx !== idx);
            clearAppliedDiscount('El ticket cambió. Vuelve a aplicar el código para recalcular el descuento.', 'error');
            renderTicket();
            syncHiddens();
        }

        function renderTicket() {
            const lines = document.getElementById('ticket-lines');
            const empty = document.getElementById('ticket-empty');
            const summary = document.getElementById('ticket-summary');

            if (ticketItems.length === 0) {
                lines.innerHTML = '';
                empty.style.display = '';
                summary.style.display = 'none';
                appliedDiscount = null;
                setDiscountFeedback('', null);
                return;
            }

            empty.style.display = 'none';
            summary.style.display = '';

            lines.innerHTML = ticketItems.map((item) => `
                <div class="ticket-line">
                    <div class="ticket-main">
                        <span class="tl-name">${escapeHtml(item.name)}</span>
                        <div class="ticket-meta">
                            <span class="tl-badge">${item.size}</span>
                            <span class="tl-qty">x${item.quantity}</span>
                            <span class="tl-price">€${(unitPriceForItem(item) * item.quantity).toFixed(2)}</span>
                        </div>
                    </div>
                    <button type="button" class="tl-del" onclick="removeItem(${item.idx})" aria-label="Eliminar línea">
                        ✕
                    </button>
                </div>
            `).join('');

            const total = ticketItems.reduce((sum, item) => sum + (unitPriceForItem(item) * item.quantity), 0);
            const units = ticketItems.reduce((sum, item) => sum + item.quantity, 0);

            document.getElementById('ticket-count').textContent = `${units} unidad${units === 1 ? '' : 'es'}`;
            const discountAmount = appliedDiscount?.discount_amount || 0;
            const finalTotal = Math.max(total - discountAmount, 0);

            document.getElementById('ticket-subtotal').textContent = `€${total.toFixed(2)}`;
            document.getElementById('ticket-discount').textContent = `−€${Number(discountAmount).toFixed(2)}`;
            document.getElementById('ticket-total').textContent = `€${finalTotal.toFixed(2)}`;
        }

        async function applyDiscount() {
            const codeInput = document.getElementById('discount_code');
            const code = String(codeInput?.value || '').trim();

            if (!code) {
                clearAppliedDiscount('Introduce un código antes de pulsar “Aplicar”.', 'error');
                return;
            }

            if (ticketItems.length === 0) {
                clearAppliedDiscount('Añade al menos una tarta al ticket antes de aplicar el código.', 'error');
                return;
            }

            const button = document.getElementById('apply-discount-btn');
            const previousText = button.textContent;
            button.disabled = true;
            button.textContent = 'Validando...';

            try {
                const payload = {
                    discount_code: code,
                    pedido: ticketItems.map((item) => ({
                        cake_id: item.cakeId,
                        size: item.size,
                        quantity: item.quantity,
                    })),
                };

                const response = await fetch(DISCOUNT_PREVIEW_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    body: JSON.stringify(payload),
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    appliedDiscount = null;
                    renderTicket();
                    setDiscountFeedback(data.message || 'No se pudo aplicar el código.', 'error');
                    return;
                }

                appliedDiscount = {
                    code,
                    discount_amount: Number(data.discount_amount || 0),
                };
                renderTicket();
                setDiscountFeedback(data.message || 'Código aplicado correctamente.', 'success');
            } catch (error) {
                appliedDiscount = null;
                renderTicket();
                setDiscountFeedback('No se pudo validar el código ahora mismo. Inténtalo de nuevo.', 'error');
            } finally {
                button.disabled = false;
                button.textContent = previousText;
            }
        }

        function clearAppliedDiscount(message = '', tone = null, silent = false) {
            const hadAppliedDiscount = Boolean(appliedDiscount);
            appliedDiscount = null;
            renderTicket();
            if (!silent && message && hadAppliedDiscount) {
                setDiscountFeedback(message, tone || 'error');
            }
            if (silent) {
                setDiscountFeedback('', null);
            }
        }

        function setDiscountFeedback(message, tone) {
            const box = document.getElementById('discount-feedback');
            if (!box) return;

            box.classList.remove('show', 'success', 'error');
            if (!message) {
                box.textContent = '';
                return;
            }

            box.textContent = message;
            box.classList.add('show', tone === 'success' ? 'success' : 'error');
        }

        function syncHiddens() {
            const form = document.getElementById('order-form');
            form.querySelectorAll('input[name="cake_id"], input[name^="pedido["]').forEach((node) => node.remove());

            if (ticketItems.length > 0) {
                const firstCake = document.createElement('input');
                firstCake.type = 'hidden';
                firstCake.name = 'cake_id';
                firstCake.value = String(ticketItems[0].cakeId);
                form.appendChild(firstCake);
            }

            ticketItems.forEach((item, index) => {
                const payload = {
                    cake_id: item.cakeId,
                    size: item.size,
                    quantity: item.quantity,
                };

                Object.entries(payload).forEach(([key, value]) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = `pedido[${index}][${key}]`;
                    input.value = String(value);
                    form.appendChild(input);
                });
            });
        }

        function validateTicket(event) {
            if (ticketItems.length === 0) {
                event.preventDefault();
                const ticket = document.getElementById('ticket-area');
                ticket.style.borderColor = 'rgba(255,107,107,0.82)';
                ticket.style.borderStyle = 'solid';
                ticket.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => {
                    ticket.style.borderColor = '';
                    ticket.style.borderStyle = '';
                }, 1400);
                return;
            }

            const deliveryDateInput = document.getElementById('delivery_date');
            const selectedDate = String(deliveryDateInput?.value || '').trim();

            if (!selectedDate) {
                return;
            }

            if (isTodayOrBlockedDate(selectedDate)) {
                event.preventDefault();
                setDeliveryDateError('La fecha seleccionada no esta disponible. Elige otra fecha.');
                deliveryDateInput?.focus();
                openDatePicker(deliveryDateInput);
            }
        }

        function setupDeliveryDatePicker() {
            const wrap = document.getElementById('delivery-date-wrap');
            const input = document.getElementById('delivery_date');
            if (!wrap || !input) return;

            const syncDeliveryPreviewTone = (instance) => {
                if (!instance?.altInput) return;
                const hasValue = String(instance.input?.value || '').trim() !== '';
                instance.altInput.classList.toggle('is-empty', !hasValue);
            };

            const tomorrow = input.dataset.minDate || dateToYmd(new Date(Date.now() + (24 * 60 * 60 * 1000)));
            const flatpickrSpanishLocale = window.flatpickr?.l10ns?.es
                ? { ...window.flatpickr.l10ns.es, firstDayOfWeek: 1 }
                : { firstDayOfWeek: 1 };

            if (typeof window.flatpickr === 'function') {
                input._flatpickr?.destroy();

                window.flatpickr(input, {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd/m/Y',
                    altInputClass: 'delivery-date-preview',
                    locale: flatpickrSpanishLocale,
                    minDate: tomorrow,
                    disableMobile: true,
                    disable: [
                        (date) => {
                            const ymd = dateToYmd(date);
                            return isTodayOrBlockedDate(ymd);
                        },
                    ],
                    onDayCreate: function (_, __, ___, dayElem) {
                        if (!dayElem?.dateObj) return;
                        const ymd = dateToYmd(dayElem.dateObj);
                        if (!isTodayOrBlockedDate(ymd)) return;

                        dayElem.classList.add('fp-day-blocked');
                        dayElem.setAttribute('title', 'Fecha bloqueada');
                    },
                    onChange: function (_, dateStr, instance) {
                        syncDeliveryPreviewTone(instance);

                        if (!dateStr) {
                            clearDeliveryDateError();
                            return;
                        }

                        if (isTodayOrBlockedDate(dateStr)) {
                            instance.clear();
                            setDeliveryDateError('La fecha seleccionada no esta disponible. Elige otra fecha.');
                            instance.open();
                            return;
                        }

                        clearDeliveryDateError();
                    },
                    onReady: function (_, __, instance) {
                        if (instance.altInput) {
                            instance.altInput.placeholder = 'dd/mm/aaaa';
                            instance.altInput.setAttribute('aria-label', 'Fecha de recogida');
                        }

                        syncDeliveryPreviewTone(instance);

                        const initialDate = String(instance.input.value || '').trim();
                        if (!initialDate) return;

                        if (!instance.selectedDates.length) {
                            instance.setDate(initialDate, false, 'Y-m-d');
                        }

                        if (isTodayOrBlockedDate(initialDate)) {
                            instance.clear();
                            setDeliveryDateError('La fecha seleccionada no esta disponible. Elige otro dia.');
                            return;
                        }

                        clearDeliveryDateError();
                    },
                });
            } else {
                input.type = 'date';
                input.min = tomorrow;
            }

            wrap.addEventListener('click', () => {
                input.focus();
                openDatePicker(input);
            });

            input.addEventListener('change', () => {
                const selectedDate = String(input.value || '').trim();
                if (!selectedDate) {
                    clearDeliveryDateError();
                    return;
                }

                if (isTodayOrBlockedDate(selectedDate)) {
                    input.value = '';
                    setDeliveryDateError('La fecha seleccionada no esta disponible. Elige otra fecha.');
                    openDatePicker(input);
                    return;
                }

                clearDeliveryDateError();
            });

            const initialDate = String(input.value || '').trim();
            if (initialDate && isTodayOrBlockedDate(initialDate)) {
                input.value = '';
                setDeliveryDateError('La fecha seleccionada no esta disponible. Elige otro dia.');
            }
        }

        function openDatePicker(input) {
            if (!input) return;

            if (input._flatpickr) {
                input._flatpickr.open();
                return;
            }

            if (typeof input.showPicker === 'function') {
                try {
                    input.showPicker();
                } catch (error) {
                    // showPicker can fail on some browsers without user gesture
                }
            }
        }

        function isTodayOrBlockedDate(value) {
            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const todayYmd = `${year}-${month}-${day}`;

            const weekday = dateToIsoWeekday(value);
            const isBlockedByWeekday = weekday !== null && BLOCKED_WEEKDAYS.has(weekday);

            return value <= todayYmd || BLOCKED_DATES.has(value) || isBlockedByWeekday;
        }

        function dateToIsoWeekday(value) {
            const date = new Date(`${value}T12:00:00`);
            if (Number.isNaN(date.getTime())) {
                return null;
            }

            const day = date.getDay();
            return day === 0 ? 7 : day;
        }

        function dateToYmd(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function setDeliveryDateError(message) {
            const help = document.getElementById('delivery-date-help');
            const input = document.getElementById('delivery_date');
            if (!help || !input) return;

            help.textContent = message;
            help.classList.add('error');
            input.style.borderColor = 'rgba(255,107,107,0.9)';
        }

        function clearDeliveryDateError() {
            const help = document.getElementById('delivery-date-help');
            const input = document.getElementById('delivery_date');
            if (!help || !input) return;

            help.textContent = help.dataset.defaultMessage || 'Fecha disponible segun reglas de agenda.';
            help.classList.remove('error');
            input.style.borderColor = '';
        }

        function hydrateOldItems() {
            if (!Array.isArray(oldItems) || oldItems.length === 0) return;

            oldItems.forEach((raw) => {
                const cakeId = parseInt(raw.cake_id, 10);
                const quantity = Math.max(1, Math.min(99, parseInt(raw.quantity ?? raw.cantidad ?? 1, 10) || 1));
                const size = normalizeSizeAlias(raw.size ?? raw.tamano ?? 'BITE');
                const cake = CAKES.find((entry) => entry.id === cakeId);
                if (!cake) return;

                ticketItems.push({
                    idx: ticketIdx++,
                    cakeId,
                    name: cake.name,
                    priceS: Number(cake.price_s || 0),
                    priceL: Number(cake.price_l || 0),
                    size,
                    quantity,
                });
            });

            renderTicket();
            syncHiddens();
        }

        function configureHeroVideo() {
            const heroVideo = document.getElementById('hero-video');
            const heroFallback = document.getElementById('hero-fallback-image');
            if (!heroVideo) return;

            const isMobile = window.matchMedia('(max-width: 767px)').matches;
            const allowMobileAutoplay = heroVideo.dataset.mobileAutoplay === '1';
            const shouldAttemptAutoplay = !isMobile || allowMobileAutoplay;

            heroVideo.hidden = false;
            if (heroFallback) heroFallback.hidden = true;
            heroVideo.muted = true;
            heroVideo.setAttribute('playsinline', '');
            heroVideo.setAttribute('webkit-playsinline', '');

            if (isMobile && !allowMobileAutoplay) {
                heroVideo.controls = true;
                heroVideo.removeAttribute('autoplay');
            } else {
                heroVideo.controls = false;
            }

            if (shouldAttemptAutoplay) {
                const playAttempt = heroVideo.play();
                if (playAttempt && typeof playAttempt.catch === 'function') {
                    playAttempt.catch(() => {
                        if (isMobile) {
                            heroVideo.controls = true;
                        } else {
                            heroVideo.hidden = true;
                            if (heroFallback) heroFallback.hidden = false;
                        }
                    });
                }
            }
        }


        function unitPriceForItem(item) {
            return item.size === 'PARTY' ? Number(item.priceL || 0) : Number(item.priceS || 0);
        }

        function normalizeSizeAlias(size) {
            const normalized = String(size || '').trim().toUpperCase();
            if (normalized === 'L' || normalized === 'PARTY') return 'PARTY';
            return 'BITE';
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;');
        }

        hydrateOldItems();
        setupCakeDetailModal();
        configureHeroVideo();
        setupDeliveryDatePicker();
        updateSelectedUnitPrice();
        document.getElementById('b-cake')?.addEventListener('change', updateSelectedUnitPrice);
        document.getElementById('apply-discount-btn')?.addEventListener('click', applyDiscount);
        document.getElementById('discount_code')?.addEventListener('input', () => {
            if (!appliedDiscount) return;
            clearAppliedDiscount('Has modificado el código. Pulsa “Aplicar” para validar de nuevo.', 'error');
        });
        window.addEventListener('resize', configureHeroVideo, { passive: true });
        if (flashSuccessMessage) {
            showToast(flashSuccessMessage);
        }
    </script>
    @include('components.cookie-consent')
</body>
</html>

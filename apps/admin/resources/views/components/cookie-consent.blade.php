@php
    $consentCookie = request()->cookie('peq_cookie_consent');
    $hasConsentDecision = in_array($consentCookie, ['accepted', 'rejected'], true);
@endphp

@once
    <style>
        .cookie-consent-banner {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            left: 1rem;
            z-index: 2147483000;
            display: none;
            max-width: 42rem;
            margin-inline: auto;
            border: 1px solid rgba(212, 175, 55, 0.45);
            border-radius: 0.9rem;
            background: rgba(11, 11, 11, 0.96);
            color: #f5f0df;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4);
            padding: 1rem;
        }

        .cookie-consent-banner p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.45;
        }

        .cookie-consent-link {
            color: #d4af37;
            text-underline-offset: 0.15em;
        }

        .cookie-consent-actions {
            margin-top: 0.85rem;
            display: flex;
            gap: 0.65rem;
            flex-wrap: wrap;
        }

        .cookie-consent-btn {
            appearance: none;
            border-radius: 999px;
            border: 1px solid transparent;
            padding: 0.5rem 1rem;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: filter 0.2s ease, transform 0.2s ease;
        }

        .cookie-consent-btn:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .cookie-consent-btn:focus-visible {
            outline: 2px solid #d4af37;
            outline-offset: 2px;
        }

        .cookie-consent-btn-accept {
            background: #d4af37;
            color: #111;
        }

        .cookie-consent-btn-reject {
            background: transparent;
            border-color: rgba(245, 240, 223, 0.4);
            color: #f5f0df;
        }

        @media (min-width: 768px) {
            .cookie-consent-banner {
                left: auto;
                margin-inline: 0;
            }
        }
    </style>
@endonce

<div
    id="peq-cookie-consent"
    class="cookie-consent-banner"
    role="dialog"
    aria-live="polite"
    aria-label="Consentimiento de cookies"
    data-ga4-measurement-id="{{ config('peq.ga4_measurement_id') }}"
    @if (! $hasConsentDecision) data-show-on-load="1" @endif
>
    <p>
        Usamos cookies esenciales para que la web funcione correctamente. Con tu consentimiento, también utilizamos cookies de análisis para entender el uso y mejorar la experiencia.
        <a class="cookie-consent-link" href="{{ route('legal.cookies') }}">Política de Cookies</a>.
    </p>

    <div class="cookie-consent-actions">
        <button type="button" class="cookie-consent-btn cookie-consent-btn-accept" data-cookie-consent="accept">
            Aceptar
        </button>
        <button type="button" class="cookie-consent-btn cookie-consent-btn-reject" data-cookie-consent="reject">
            Rechazar
        </button>
    </div>
</div>

@once
    <script>
        (function () {
            const CONSENT_COOKIE_NAME = 'peq_cookie_consent';
            const CONSENT_MAX_AGE_SECONDS = 60 * 60 * 24 * 365;
            const GA4_SCRIPT_ID = 'peq-ga4-script';
            let GA4_MEASUREMENT_ID = '';

            function getCookieValue(name) {
                const escapedName = name.replace(/([.$?*|{}()\[\]\\/+^])/g, '\\$1');
                const match = document.cookie.match(new RegExp('(?:^|; )' + escapedName + '=([^;]*)'));
                return match ? decodeURIComponent(match[1]) : null;
            }

            function persistConsent(value) {
                const secureFlag = window.location.protocol === 'https:' ? '; Secure' : '';
                document.cookie = CONSENT_COOKIE_NAME
                    + '=' + encodeURIComponent(value)
                    + '; Max-Age=' + CONSENT_MAX_AGE_SECONDS
                    + '; Path=/'
                    + '; SameSite=Lax'
                    + secureFlag;
            }

            function enableGa4Tracking() {
                if (!GA4_MEASUREMENT_ID || window.__peqGa4Initialized) {
                    return;
                }

                window.__peqGa4Initialized = true;
                window.dataLayer = window.dataLayer || [];
                window.gtag = window.gtag || function () {
                    window.dataLayer.push(arguments);
                };

                window.gtag('js', new Date());
                window.gtag('config', GA4_MEASUREMENT_ID);

                if (!document.getElementById(GA4_SCRIPT_ID)) {
                    const script = document.createElement('script');
                    script.id = GA4_SCRIPT_ID;
                    script.async = true;
                    script.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(GA4_MEASUREMENT_ID);
                    document.head.appendChild(script);
                }
            }

            const existingEnableOptionalCookies = window.peqEnableOptionalCookies;
            window.peqEnableOptionalCookies = function () {
                if (typeof existingEnableOptionalCookies === 'function') {
                    existingEnableOptionalCookies();
                }

                enableGa4Tracking();
            };

            const banner = document.getElementById('peq-cookie-consent');
            if (!banner) {
                return;
            }

            GA4_MEASUREMENT_ID = banner.dataset.ga4MeasurementId || '';

            const currentConsent = getCookieValue(CONSENT_COOKIE_NAME);
            if (currentConsent === 'accepted') {
                window.peqEnableOptionalCookies();
                return;
            }

            if (currentConsent === 'rejected') {
                return;
            }

            if (banner.dataset.showOnLoad === '1') {
                banner.style.display = 'block';
            }

            const acceptButton = banner.querySelector('[data-cookie-consent="accept"]');
            const rejectButton = banner.querySelector('[data-cookie-consent="reject"]');

            function saveAndClose(consentValue) {
                persistConsent(consentValue);
                banner.style.display = 'none';

                if (consentValue === 'accepted') {
                    window.peqEnableOptionalCookies();
                }
            }

            acceptButton?.addEventListener('click', function () {
                saveAndClose('accepted');
            });

            rejectButton?.addEventListener('click', function () {
                saveAndClose('rejected');
            });
        })();
    </script>
@endonce

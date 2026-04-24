<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Informes · PEQ Cakes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.css">
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-500">PEQ Cakes</p>
                <h1 class="text-lg font-bold text-slate-900">Informes de Pedidos</h1>
            </div>
            <div class="flex items-center gap-2 text-sm">
                @include('admin.partials.top-nav')
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="rounded-lg bg-slate-900 px-3 py-2 font-semibold text-white hover:bg-slate-700">Salir</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto w-full max-w-7xl space-y-6 px-4 py-6 sm:px-6">
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-bold text-slate-900">Exportar pedidos por rango de fechas</h2>
            <p class="mt-1 text-sm text-slate-500">Selecciona un rango de fechas (inclusive) para descargar un Excel con todos los pedidos de ese periodo. Si no hay pedidos, el archivo se genera con solo encabezados.</p>

            <form method="POST" action="{{ route('admin.reports.export-orders') }}" class="mt-5 flex flex-wrap items-end gap-3">
                @csrf

                <div>
                    <label for="from" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Desde</label>
                    <input
                        id="from"
                        name="from"
                        type="text"
                        value="{{ old('from', $from) }}"
                        required
                        placeholder="dd/mm/yyyy"
                        class="date-picker rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                    >
                </div>

                <div>
                    <label for="to" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Hasta</label>
                    <input
                        id="to"
                        name="to"
                        type="text"
                        value="{{ old('to', $to) }}"
                        required
                        placeholder="dd/mm/yyyy"
                        class="date-picker rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-100"
                    >
                </div>

                <button type="submit" class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">
                    Descargar Excel
                </button>
            </form>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/l10n/es.js"></script>
    <script>
        const flatpickrSpanishLocale = window.flatpickr?.l10ns?.es
            ? { ...window.flatpickr.l10ns.es, firstDayOfWeek: 1 }
            : undefined;

        document.querySelectorAll('.date-picker').forEach(function (input) {
            if (typeof window.flatpickr === 'function') {
                input._flatpickr?.destroy();
                window.flatpickr(input, {
                    dateFormat: 'Y-m-d',
                    locale: flatpickrSpanishLocale,
                });
            }
        });
    </script>
</body>
</html>

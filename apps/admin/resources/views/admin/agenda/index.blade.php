<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Agenda · PEQ Cakes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-amber-500">PEQ Cakes</p>
                <h1 class="text-lg font-bold text-slate-900">Agenda de Pedidos</h1>
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
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">{{ session('success') }}</div>
        @endif

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <h2 class="text-base font-bold text-slate-900">Reglas de antelacion de pedidos</h2>
            <p class="mt-1 text-sm text-slate-500">Define hora de corte y dias minimos para habilitar fechas de recogida en el calendario publico.</p>

            <form method="POST" action="{{ route('admin.agenda.lead-time.update') }}" class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4 lg:items-end">
                @csrf
                @method('PUT')

                <div>
                    <label for="cutoff_time" class="mb-1 block text-xs font-medium text-slate-500">Hora de corte</label>
                    <input
                        id="cutoff_time"
                        type="time"
                        name="cutoff_time"
                        step="60"
                        value="{{ old('cutoff_time', $agendaSetting->resolveCutoffTime()) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-100"
                    >
                </div>

                <div>
                    <label for="min_days_before_cutoff" class="mb-1 block text-xs font-medium text-slate-500">Dias minimos antes del corte</label>
                    <input
                        id="min_days_before_cutoff"
                        type="number"
                        name="min_days_before_cutoff"
                        min="1"
                        max="30"
                        value="{{ old('min_days_before_cutoff', $agendaSetting->min_days_before_cutoff) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-100"
                    >
                </div>

                <div>
                    <label for="min_days_after_cutoff" class="mb-1 block text-xs font-medium text-slate-500">Dias minimos despues del corte</label>
                    <input
                        id="min_days_after_cutoff"
                        type="number"
                        name="min_days_after_cutoff"
                        min="1"
                        max="30"
                        value="{{ old('min_days_after_cutoff', $agendaSetting->min_days_after_cutoff) }}"
                        required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-100"
                    >
                </div>

                <div>
                    <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">Guardar reglas</button>
                </div>
            </form>
        </section>

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
            <h2 class="text-base font-bold text-slate-900">Bloqueo semanal global</h2>
            <p class="mt-1 text-sm text-slate-500">Marca los dias de la semana en los que no se aceptan pedidos (aplica a todas las fechas).</p>

            <form method="POST" action="{{ route('admin.blocked-weekdays.update') }}" class="mt-4 space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($weekdayOptions as $value => $label)
                        <label class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700">
                            <input
                                type="checkbox"
                                name="weekdays[]"
                                value="{{ $value }}"
                                class="h-4 w-4 rounded border-slate-300 text-amber-600"
                                {{ in_array($value, $blockedWeekdays, true) ? 'checked' : '' }}
                            >
                            {{ $label }}
                        </label>
                    @endforeach
                </div>

                <button type="submit" class="inline-flex items-center rounded-lg bg-amber-600 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-700">Guardar bloqueo semanal</button>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="text-base font-bold text-slate-900">Bloqueo por fechas especificas</h2>
                    <p class="mt-1 text-sm text-slate-500">Añade o quita dias concretos no disponibles para pedidos.</p>
                </div>

                <form method="POST" action="{{ route('admin.blocked-days.store') }}" class="flex flex-wrap items-end gap-2">
                    @csrf
                    <div>
                        <label for="blocked-day-date" class="mb-1 block text-xs font-medium text-slate-500">Fecha</label>
                        <input
                            id="blocked-day-date"
                            type="date"
                            name="date"
                            min="{{ $minimumPickupDate }}"
                            required
                            class="rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-900 focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-100"
                        >
                    </div>

                    <button type="submit" class="inline-flex items-center rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Bloquear fecha</button>
                </form>
            </div>

            <div class="mt-4 flex flex-wrap gap-2">
                @forelse ($blockedDays as $blockedDay)
                    <form method="POST" action="{{ route('admin.blocked-days.destroy', $blockedDay) }}" class="inline-flex">
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            data-day="{{ $blockedDay->date->format('d/m/Y') }}"
                            onclick="requireConfirm(event, '¿Quitar bloqueo de la fecha ' + this.dataset.day + '?')"
                            class="inline-flex items-center gap-2 rounded-full border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-100"
                        >
                            {{ $blockedDay->date->format('d/m/Y') }}
                            <span aria-hidden="true">✕</span>
                        </button>
                    </form>
                @empty
                    <p class="text-sm text-slate-400">No hay fechas bloqueadas.</p>
                @endforelse
            </div>
        </section>
    </main>

    <script>
        function requireConfirm(event, message) {
            if (!window.confirm(message)) {
                event.preventDefault();
                event.stopPropagation();
            }
        }
    </script>
</body>
</html>

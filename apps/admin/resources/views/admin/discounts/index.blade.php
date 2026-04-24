<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Descuentos · PEQ Cakes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-500">PEQ Cakes</p>
                <h1 class="text-lg font-bold text-slate-900">Gestión de Descuentos</h1>
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
            <h2 class="text-base font-bold text-slate-900">Nuevo descuento</h2>
            <p class="mt-1 text-sm text-slate-500">Soporta códigos y descuentos automáticos con límites y ventanas de tiempo.</p>

            <form method="POST" action="{{ route('admin.discounts.store') }}" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                <div>
                    <label for="name" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="discount_type" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Tipo</label>
                    <select id="discount_type" name="discount_type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                        <option value="code" {{ old('discount_type', 'code') === 'code' ? 'selected' : '' }}>Código</option>
                        <option value="automatic" {{ old('discount_type') === 'automatic' ? 'selected' : '' }}>Automático</option>
                    </select>
                </div>
                <div>
                    <label for="code" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Código</label>
                    <input id="code" name="code" type="text" value="{{ old('code') }}" placeholder="SAVE10" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm uppercase focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="value_type" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Tipo de valor</label>
                    <select id="value_type" name="value_type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                        <option value="percentage" {{ old('value_type', 'percentage') === 'percentage' ? 'selected' : '' }}>Porcentaje (%)</option>
                        <option value="fixed" {{ old('value_type') === 'fixed' ? 'selected' : '' }}>Importe fijo (€)</option>
                    </select>
                </div>
                <div>
                    <label for="value" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Valor</label>
                    <input id="value" name="value" type="number" min="0.01" step="0.01" required value="{{ old('value') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="min_order_amount" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Pedido mínimo (€)</label>
                    <input id="min_order_amount" name="min_order_amount" type="number" min="0" step="0.01" value="{{ old('min_order_amount') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="max_uses" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Máx. usos</label>
                    <input id="max_uses" name="max_uses" type="number" min="1" step="1" value="{{ old('max_uses') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="times_used" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Usos actuales</label>
                    <input id="times_used" name="times_used" type="number" min="0" step="1" value="{{ old('times_used', 0) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="starts_at" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Inicio</label>
                    <input id="starts_at" name="starts_at" type="datetime-local" value="{{ old('starts_at') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <div>
                    <label for="ends_at" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Fin</label>
                    <input id="ends_at" name="ends_at" type="datetime-local" value="{{ old('ends_at') }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                </div>
                <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700 md:col-span-2">
                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-violet-600" {{ old('is_active', true) ? 'checked' : '' }}>
                    Activo
                </label>
                <div class="md:col-span-2">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">Guardar descuento</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                <h2 class="text-base font-bold text-slate-900">Listado de descuentos</h2>
            </div>

            <div class="space-y-4 p-4 sm:p-6">
                @forelse ($discounts as $discount)
                    <article class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                            <div>
                                <p class="text-sm font-bold text-slate-900">{{ $discount->name }}</p>
                                <p class="text-xs text-slate-500">
                                    {{ $discount->is_automatic ? 'Automático' : 'Código: ' . $discount->code }}
                                    · {{ $discount->value_type === 'percentage' ? rtrim(rtrim(number_format((float) $discount->value, 2), '0'), '.') . '%' : '€' . number_format((float) $discount->value, 2) }}
                                </p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex rounded-full border px-2.5 py-1 text-xs font-semibold {{ $discount->is_active ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-slate-300 bg-white text-slate-500' }}">
                                    {{ $discount->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                                <span class="inline-flex rounded-full border border-violet-200 bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700">
                                    {{ $discount->is_automatic ? 'Automático' : 'Código' }}
                                </span>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.discounts.update', $discount) }}" class="grid gap-2 md:grid-cols-4">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $discount->name }}" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                            <select name="discount_type" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                                <option value="code" {{ ! $discount->is_automatic ? 'selected' : '' }}>Código</option>
                                <option value="automatic" {{ $discount->is_automatic ? 'selected' : '' }}>Automático</option>
                            </select>
                            <input type="text" name="code" value="{{ $discount->code }}" placeholder="Código" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs uppercase">
                            <select name="value_type" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                                <option value="percentage" {{ $discount->value_type === 'percentage' ? 'selected' : '' }}>%</option>
                                <option value="fixed" {{ $discount->value_type === 'fixed' ? 'selected' : '' }}>€ fijo</option>
                            </select>

                            <input type="number" step="0.01" min="0.01" name="value" value="{{ $discount->value }}" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                            <input type="number" step="0.01" min="0" name="min_order_amount" value="{{ $discount->min_subtotal }}" placeholder="Mín. pedido" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                            <input type="number" min="1" step="1" name="max_uses" value="{{ $discount->max_uses }}" placeholder="Máx. usos" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                            <input type="number" min="0" step="1" name="times_used" value="{{ $discount->times_used }}" placeholder="Usos" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">

                            <input type="datetime-local" name="starts_at" value="{{ optional($discount->starts_at)->format('Y-m-d\TH:i') }}" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                            <input type="datetime-local" name="ends_at" value="{{ optional($discount->ends_at)->format('Y-m-d\TH:i') }}" class="rounded-md border border-slate-300 px-2 py-1.5 text-xs">
                            <label class="inline-flex items-center gap-2 rounded-md border border-slate-300 bg-white px-2 py-1.5 text-xs font-medium text-slate-700">
                                <input type="checkbox" name="is_active" value="1" class="h-3.5 w-3.5" {{ $discount->is_active ? 'checked' : '' }}>
                                Activo
                            </label>
                            <div class="flex flex-wrap items-center gap-2 md:justify-end">
                                <button type="submit" class="rounded-md bg-violet-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-violet-700">Actualizar</button>
                            </div>
                        </form>

                        <div class="mt-3 flex flex-wrap gap-2">
                            <form method="POST" action="{{ route('admin.discounts.toggle-active', $discount) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="rounded-md border border-amber-200 bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-100">
                                    {{ $discount->is_active ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.discounts.destroy', $discount) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Eliminar este descuento?')" class="rounded-md border border-rose-200 bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-100">Eliminar</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <p class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-10 text-center text-sm text-slate-500">No hay descuentos activos. Los de un solo uso consumidos desaparecen automáticamente.</p>
                @endforelse
            </div>
        </section>
    </main>
</body>
</html>

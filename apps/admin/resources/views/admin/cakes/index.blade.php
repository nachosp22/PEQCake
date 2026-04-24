<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Tartas · PEQ Cakes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-rose-500">PEQ Cakes</p>
                <h1 class="text-lg font-bold text-slate-900">Gestión de Tartas</h1>
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
            <h2 class="text-base font-bold text-slate-900">Nueva tarta</h2>
            <p class="mt-1 text-sm text-slate-500">Crea una nueva tarta del catálogo con precios S/L y orden manual.</p>

            <form method="POST" action="{{ route('admin.cakes.store') }}" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                @php($allergenOptions = \App\Models\Cake::allergenOptions())
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500" for="name">Nombre</label>
                    <input id="name" name="name" type="text" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" value="{{ old('name') }}">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500" for="image_url">Imagen URL</label>
                    <input id="image_url" name="image_url" type="text" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" value="{{ old('image_url') }}" placeholder="https://... o nombre de archivo (ej: tarta-chocolate.jpg)">
                </div>
                <div class="md:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500" for="description">Descripción</label>
                    <textarea id="description" name="description" rows="2" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('description') }}</textarea>
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500" for="price_s">Precio S (€)</label>
                    <input id="price_s" name="price_s" type="number" min="0" step="0.01" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" value="{{ old('price_s') }}">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500" for="price_l">Precio L (€)</label>
                    <input id="price_l" name="price_l" type="number" min="0" step="0.01" required class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" value="{{ old('price_l') }}">
                </div>
                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500" for="sort_order">Orden</label>
                    <input id="sort_order" name="sort_order" type="number" min="0" step="1" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100" value="{{ old('sort_order', 0) }}">
                </div>
                <label class="mt-6 inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                    <input type="checkbox" name="is_available" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600" {{ old('is_available', true) ? 'checked' : '' }}>
                    Disponible para venta
                </label>
                <div class="md:col-span-2">
                    <p class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Alergenos</p>
                    <div class="grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($allergenOptions as $allergenField => $allergenLabel)
                            <label class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-700">
                                <input type="checkbox" name="{{ $allergenField }}" value="1" class="h-4 w-4 rounded border-slate-300 text-blue-600" {{ old($allergenField) ? 'checked' : '' }}>
                                {{ $allergenLabel }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="inline-flex items-center rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Guardar tarta</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                <h2 class="text-base font-bold text-slate-900">Listado de tartas</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-fixed">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="w-2/12 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Tarta</th>
                            <th class="w-1/12 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Precio</th>
                            <th class="w-1/12 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Estado</th>
                            <th class="w-1/12 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-slate-500">Orden</th>
                            <th class="w-7/12 bg-blue-50 px-4 py-3 text-xs font-bold uppercase tracking-wide text-blue-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($cakes as $cake)
                            <tr class="align-top">
                                <td class="px-4 py-4">
                                    <p class="font-semibold text-slate-900">{{ $cake->name }}</p>
                                </td>
                                <td class="px-4 py-4 text-sm">
                                    <p>S: <span class="font-semibold">€{{ number_format((float) $cake->price_s, 2) }}</span></p>
                                    <p>L: <span class="font-semibold">€{{ number_format((float) $cake->price_l, 2) }}</span></p>
                                </td>
                                <td class="px-4 py-4">
                                    @if ($cake->trashed())
                                        <span class="inline-flex rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1 text-xs font-semibold text-rose-700">Eliminada</span>
                                    @elseif ($cake->is_available)
                                        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">Disponible</span>
                                    @else
                                        <span class="inline-flex rounded-full border border-amber-200 bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">No disponible</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-sm font-medium text-slate-700">{{ $cake->sort_order }}</td>
                                <td class="px-4 py-4">
                                    @if (! $cake->trashed())
                                        <form method="POST" action="{{ route('admin.cakes.update', $cake) }}" class="grid gap-3 rounded-xl border-2 border-blue-200 bg-blue-50/50 p-4 md:grid-cols-3">
                                            @csrf
                                            @method('PUT')
                                            <div class="md:col-span-3">
                                                <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Descripción</label>
                                                <textarea name="description" rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2.5 text-base leading-7">{{ $cake->description }}</textarea>
                                            </div>
                                            <input type="text" name="name" value="{{ $cake->name }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                                            <input type="number" min="0" step="0.01" name="price_s" value="{{ $cake->price_s }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                                            <input type="number" min="0" step="0.01" name="price_l" value="{{ $cake->price_l }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                                            <input type="number" min="0" step="1" name="sort_order" value="{{ $cake->sort_order }}" class="rounded-md border border-slate-300 px-3 py-2 text-sm">
                                            <input type="text" name="image_url" value="{{ $cake->image_url }}" placeholder="URL o archivo" class="rounded-md border border-slate-300 px-3 py-2 text-sm md:col-span-2">
                                            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                                <input type="checkbox" name="is_available" value="1" class="h-3.5 w-3.5" {{ $cake->is_available ? 'checked' : '' }}>
                                                Disponible
                                            </label>
                                            <div class="grid gap-1 md:col-span-3 md:grid-cols-3">
                                                @foreach ($allergenOptions as $allergenField => $allergenLabel)
                                                    <label class="inline-flex items-center gap-1.5 text-xs text-slate-700">
                                                        <input type="checkbox" name="{{ $allergenField }}" value="1" class="h-3.5 w-3.5" {{ $cake->{$allergenField} ? 'checked' : '' }}>
                                                        {{ $allergenLabel }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div class="flex flex-wrap gap-2 md:col-span-2 md:justify-end">
                                                <button type="submit" class="rounded-md bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">Actualizar</button>
                                            </div>
                                        </form>
                                        <form method="POST" action="{{ route('admin.cakes.destroy', $cake) }}" class="mt-2">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('¿Eliminar esta tarta?')" class="rounded-md border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">Soft-delete</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.cakes.restore', $cake) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">Restaurar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-sm text-slate-500">No hay tartas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>

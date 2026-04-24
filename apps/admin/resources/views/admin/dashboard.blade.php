<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración · PEQ Cakes</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.app-modal-sizing-styles')
</head>
<body class="bg-slate-100 min-h-screen antialiased text-slate-800">

    {{-- ============================================================ --}}
    {{-- HEADER                                                       --}}
    {{-- ============================================================ --}}
    <header class="bg-white/95 border-b border-slate-200 shadow-sm sticky top-0 z-10 backdrop-blur">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center text-xl select-none">🎂</div>
                <div>
                    <h1 class="text-lg font-bold text-gray-900 leading-tight">PEQ Cakes</h1>
                        <p class="text-xs text-slate-400 leading-none">Panel de Administración</p>
                    </div>
                </div>
            <div class="flex items-center gap-2 sm:gap-4">
                @include('admin.partials.top-nav')
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-medium text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">Administrador</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        {{-- ============================================================ --}}
        {{-- FLASH MESSAGE                                                --}}
        {{-- ============================================================ --}}
        @if (session('success'))
            <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl" role="alert">
                <ul class="list-disc pl-5 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ============================================================ --}}
        {{-- TARJETAS DE ESTADÍSTICAS                                     --}}
        {{-- ============================================================ --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Total Pedidos</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $stats['total'] }}</p>
                <div class="mt-3 w-8 h-1 bg-gray-200 rounded-full"></div>
            </div>

            <div class="bg-white rounded-2xl border border-amber-100 shadow-sm p-5">
                <p class="text-xs font-semibold text-amber-500 uppercase tracking-wider">Pendientes</p>
                <p class="text-3xl font-bold text-amber-600 mt-1">{{ $stats['pending'] }}</p>
                <div class="mt-3 w-8 h-1 bg-amber-200 rounded-full"></div>
            </div>

            <div class="bg-white rounded-2xl border border-blue-100 shadow-sm p-5">
                <p class="text-xs font-semibold text-blue-500 uppercase tracking-wider">Confirmados</p>
                <p class="text-3xl font-bold text-blue-600 mt-1">{{ $stats['confirmed'] }}</p>
                <div class="mt-3 w-8 h-1 bg-blue-200 rounded-full"></div>
            </div>

            <div class="bg-white rounded-2xl border border-green-100 shadow-sm p-5">
                <p class="text-xs font-semibold text-green-500 uppercase tracking-wider">Pagados</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $stats['paid'] }}</p>
                <div class="mt-3 w-8 h-1 bg-green-200 rounded-full"></div>
            </div>

        </div>

        {{-- ============================================================ --}}
        {{-- FILTROS DE BÚSQUEDA                                          --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <div class="flex items-center gap-2 mb-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/>
                </svg>
                <h2 class="text-sm font-semibold text-gray-700">Filtros de búsqueda</h2>
            </div>

            <form method="GET" action="{{ route('admin.dashboard') }}">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    {{-- Búsqueda por cliente / email --}}
                    <div>
                        <label for="filter-search" class="block text-xs font-medium text-gray-500 mb-1">Cliente o Email</label>
                        <input id="filter-search"
                               type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Buscar nombre o email..."
                               class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    {{-- Fecha recogida desde --}}
                    <div>
                        <label for="filter-date-from" class="block text-xs font-medium text-gray-500 mb-1">Recogida — Desde</label>
                        <input id="filter-date-from"
                               type="date"
                               name="date_from"
                               value="{{ request('date_from') }}"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    {{-- Fecha recogida hasta --}}
                    <div>
                        <label for="filter-date-to" class="block text-xs font-medium text-gray-500 mb-1">Recogida — Hasta</label>
                        <input id="filter-date-to"
                               type="date"
                               name="date_to"
                               value="{{ request('date_to') }}"
                               class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label for="filter-status" class="block text-xs font-medium text-gray-500 mb-1">Estado</label>
                        <select id="filter-status"
                                name="status"
                                class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            <option value="">Todos los estados</option>
                            <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>⏳ Pendiente</option>
                            <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>✅ Confirmado</option>
                            <option value="paid"      {{ request('status') === 'paid'      ? 'selected' : '' }}>💰 Pagado</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>🏁 Completado</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>❌ Cancelado</option>
                        </select>
                    </div>

                </div>

                <div class="flex flex-wrap items-center gap-3 mt-4">
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold shadow-sm transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        Aplicar filtros
                    </button>
                    <a href="{{ route('admin.dashboard') }}"
                       class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-600 px-5 py-2 rounded-lg text-sm font-medium transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                        Limpiar
                    </a>
                    @if (request()->hasAny(['search', 'date_from', 'date_to', 'status']))
                        <span class="text-xs text-gray-400 italic">{{ $orders->count() }} resultado(s) encontrado(s)</span>
                    @endif
                </div>
            </form>
        </div>

        {{-- ============================================================ --}}
        {{-- TABLA DE PEDIDOS                                             --}}
        {{-- ============================================================ --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            {{-- Cabecera de la tarjeta --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
                <h2 class="text-base font-semibold text-gray-900">Pedidos</h2>
                <span class="px-2.5 py-0.5 bg-gray-100 text-gray-500 text-xs font-bold rounded-full">{{ $orders->count() }}</span>
            </div>

            <div class="md:hidden p-4 space-y-3 bg-gray-50/70">
                @forelse ($orders as $order)
                    @php
                        $statusMap = [
                            'pending'   => ['label' => 'Pendiente',  'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                            'confirmed' => ['label' => 'Confirmado', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                            'paid'      => ['label' => 'Pagado',     'class' => 'bg-green-50 text-green-700 border-green-200'],
                            'completed' => ['label' => 'Completado', 'class' => 'bg-green-50 text-green-700 border-green-200'],
                            'cancelled' => ['label' => 'Cancelado',  'class' => 'bg-red-50 text-red-700 border-red-200'],
                        ];
                        $sc = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'bg-gray-50 text-gray-700 border-gray-200'];
                        $total = number_format((float) ($order->total ?? $order->cake?->price ?? 0), 2, ',', '.');
                        $discountAmountRaw = (float) ($order->discount_amount ?? 0);
                        $discountAmount = number_format($discountAmountRaw, 2, ',', '.');
                        $discountCode = $order->discount_code;
                        $itemsCount = (int) ($order->items_admin_count ?? 0);
                        $itemsQuantity = (int) ($order->items_admin_total_quantity ?? 0);
                        $primaryItemName = $order->items_admin[0]['cake_name'] ?? $order->cake?->name ?? '—';
                    @endphp

                    <article class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="text-xs font-mono font-bold text-gray-300">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</p>
                                <h3 class="text-sm font-semibold text-gray-900 mt-1">{{ $order->customer_name }}</h3>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $order->customer_email }}</p>
                                <p class="text-xs text-gray-400">{{ $order->customer_phone }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $sc['class'] }}">{{ $sc['label'] }}</span>
                        </div>

                        <dl class="grid grid-cols-2 gap-x-3 gap-y-2 mt-3 text-xs">
                            <div>
                                <dt class="text-gray-400">Recogida</dt>
                                <dd class="text-gray-700 font-medium">{{ $order->pickup_date ? $order->pickup_date->format('d/m/Y') : '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-gray-400">Total</dt>
                                <dd class="text-gray-900 font-bold">{{ $total }} €</dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-gray-400">Descuento</dt>
                                <dd class="text-gray-700 font-medium">
                                    @if ($discountAmountRaw > 0)
                                        {{ $discountCode ?: 'Automático' }} · −{{ $discountAmount }} €
                                    @else
                                        Sin descuento
                                    @endif
                                </dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-gray-400">Pedido</dt>
                                <dd class="text-gray-700 font-medium">
                                    {{ $primaryItemName }}
                                    @if ($itemsCount > 1)
                                        <span class="text-gray-400">· {{ $itemsCount }} líneas / {{ $itemsQuantity }} uds</span>
                                    @endif
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-3 grid gap-2">
                            <button type="button"
                                    onclick="openDetailModal(this)"
                                    data-id="{{ $order->id }}"
                                    data-name="{{ $order->customer_name }}"
                                    data-email="{{ $order->customer_email }}"
                                    data-phone="{{ $order->customer_phone }}"
                                     data-cake="{{ $primaryItemName }}"
                                     data-pickup="{{ $order->pickup_date ? $order->pickup_date->format('d/m/Y') : '—' }}"
                                     data-total="{{ $total }}"
                                     data-discount-code="{{ $discountCode ?? '' }}"
                                     data-discount-amount="{{ $discountAmount }}"
                                     data-items="{{ json_encode($order->items_admin ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                     data-status-label="{{ $sc['label'] }}"
                                     data-status-class="{{ $sc['class'] }}"
                                    class="inline-flex items-center justify-center gap-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-xs font-semibold">
                                Ver detalle
                            </button>

                            <div class="grid grid-cols-2 gap-2">
                                @if ($order->status === 'pending')
                                    <form method="POST" action="{{ route('admin.orders.confirm', $order) }}" class="contents">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="requireConfirm(event, '¿Marcar el pedido #{{ $order->id }} como Confirmado?')"
                                                class="inline-flex items-center justify-center bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-2 py-2 rounded-lg text-xs font-semibold">
                                            Confirmar
                                        </button>
                                    </form>
                                @endif

                                @if (in_array($order->status, ['pending', 'confirmed']))
                                    <form method="POST" action="{{ route('admin.orders.pay', $order) }}" class="contents">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit"
                                                onclick="requireConfirm(event, '¿Marcar el pedido #{{ $order->id }} como Pagado?')"
                                                class="inline-flex items-center justify-center bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 px-2 py-2 rounded-lg text-xs font-semibold">
                                            Pagado
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <article class="bg-white border border-gray-200 rounded-xl p-6 text-center text-sm text-gray-400">
                        No se encontraron pedidos.
                    </article>
                @endforelse
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-left">
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Cliente</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Fecha Recogida</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tarta</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-right">Total</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Estado</th>
                            <th class="px-6 py-3 text-xs font-semibold text-gray-400 uppercase tracking-wider text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">

                        @forelse ($orders as $order)

                            @php
                                $statusMap = [
                                    'pending'   => ['label' => 'Pendiente',  'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                    'confirmed' => ['label' => 'Confirmado', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                    'paid'      => ['label' => 'Pagado',     'class' => 'bg-green-50 text-green-700 border-green-200'],
                                    'completed' => ['label' => 'Completado', 'class' => 'bg-green-50 text-green-700 border-green-200'],
                                    'cancelled' => ['label' => 'Cancelado',  'class' => 'bg-red-50 text-red-700 border-red-200'],
                                ];
                                $sc = $statusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'bg-gray-50 text-gray-700 border-gray-200'];
                                $total = number_format((float) ($order->total ?? $order->cake?->price ?? 0), 2, ',', '.');
                                $discountAmountRaw = (float) ($order->discount_amount ?? 0);
                                $discountAmount = number_format($discountAmountRaw, 2, ',', '.');
                                $discountCode = $order->discount_code;
                                $itemsCount = (int) ($order->items_admin_count ?? 0);
                                $itemsQuantity = (int) ($order->items_admin_total_quantity ?? 0);
                                $primaryItemName = $order->items_admin[0]['cake_name'] ?? $order->cake?->name ?? '—';
                             @endphp

                            <tr class="hover:bg-gray-50/60 transition-colors duration-100">

                                {{-- ID --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-mono font-bold text-gray-300">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </td>

                                {{-- Cliente --}}
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $order->customer_email }}</div>
                                    <div class="text-xs text-gray-300 mt-0.5">{{ $order->customer_phone }}</div>
                                </td>

                                {{-- Fecha Recogida --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($order->pickup_date)
                                        <div class="text-sm text-gray-800">{{ $order->pickup_date->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $order->pickup_date->diffForHumans() }}</div>
                                    @else
                                        <span class="text-gray-200 text-sm">—</span>
                                    @endif
                                </td>

                                {{-- Tarta --}}
                                <td class="px-6 py-4">
                                     <span class="text-sm text-gray-700">
                                         {{ $primaryItemName }}
                                         @if ($itemsCount > 1)
                                             <span class="text-gray-400">· +{{ $itemsCount - 1 }} línea(s) / {{ $itemsQuantity }} uds</span>
                                         @endif
                                     </span>
                                </td>

                                {{-- Total --}}
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $total }} €</span>
                                    @if ($discountAmountRaw > 0)
                                        <div class="text-[11px] text-emerald-600 font-semibold">
                                            {{ $discountCode ?: 'Automático' }} · -{{ $discountAmount }} €
                                        </div>
                                    @endif
                                </td>

                                {{-- Estado Badge --}}
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $sc['class'] }}">
                                        {{ $sc['label'] }}
                                    </span>
                                </td>

                                {{-- Acciones --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">

                                        {{-- VER DETALLE (Gris/Neutro) --}}
                                        <button type="button"
                                                onclick="openDetailModal(this)"
                                                data-id="{{ $order->id }}"
                                                data-name="{{ $order->customer_name }}"
                                                data-email="{{ $order->customer_email }}"
                                                data-phone="{{ $order->customer_phone }}"
                                                data-cake="{{ $primaryItemName }}"
                                                data-pickup="{{ $order->pickup_date ? $order->pickup_date->format('d/m/Y') : '—' }}"
                                                data-total="{{ $total }}"
                                                data-discount-code="{{ $discountCode ?? '' }}"
                                                data-discount-amount="{{ $discountAmount }}"
                                                data-items="{{ json_encode($order->items_admin ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                                                data-status-label="{{ $sc['label'] }}"
                                                data-status-class="{{ $sc['class'] }}"
                                                class="inline-flex items-center gap-1 bg-gray-100 hover:bg-gray-200 text-gray-600 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors duration-150 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                                            </svg>
                                                                                        Ver detalle
                                        </button>

                                        {{-- MARCAR CONFIRMADO (Azul) — solo si está pendiente --}}
                                        @if ($order->status === 'pending')
                                            <form method="POST"
                                                  action="{{ route('admin.orders.confirm', $order) }}"
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="requireConfirm(event, '¿Marcar el pedido #{{ $order->id }} como Confirmado?')"
                                                        class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors duration-150 whitespace-nowrap">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                        <polyline points="20 6 9 17 4 12"/>
                                                    </svg>
                                                    Confirmar
                                                </button>
                                            </form>
                                        @endif

                                        {{-- MARCAR PAGADO (Verde) — si está pendiente o confirmado --}}
                                        @if (in_array($order->status, ['pending', 'confirmed']))
                                            <form method="POST"
                                                  action="{{ route('admin.orders.pay', $order) }}"
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        onclick="requireConfirm(event, '¿Marcar el pedido #{{ $order->id }} como Pagado?')"
                                                        class="inline-flex items-center gap-1 bg-green-50 hover:bg-green-100 text-green-700 border border-green-200 px-3 py-1.5 rounded-lg text-xs font-medium transition-colors duration-150 whitespace-nowrap">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                                    </svg>
                                                    Pagado
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3 text-gray-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-14 h-14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="0.8">
                                            <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                            <rect x="9" y="3" width="6" height="4" rx="2"/>
                                            <line x1="9" y1="12" x2="15" y2="12"/><line x1="9" y1="16" x2="13" y2="16"/>
                                        </svg>
                                        <p class="text-sm font-medium text-gray-400">No se encontraron pedidos</p>
                                        <p class="text-xs text-gray-300">Prueba a ajustar los filtros de búsqueda</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

    </main>

    {{-- ============================================================ --}}
    {{-- MODAL: DETALLE DEL PEDIDO                                    --}}
    {{-- ============================================================ --}}
    <div id="detail-modal"
         class="app-modal-overlay z-50"
         style="display:none; background-color: rgba(15,23,42,0.45);"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modal-title">

        <div class="app-modal-dialog bg-white shadow-2xl">

            {{-- Modal: Encabezado --}}
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center text-lg select-none">🎂</div>
                    <div>
                        <h3 id="modal-title" class="text-base font-bold text-gray-900">Detalle del Pedido</h3>
                        <p id="modal-id" class="text-xs font-mono text-gray-400"></p>
                    </div>
                </div>
                <button onclick="closeDetailModal()"
                        aria-label="Cerrar"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 hover:bg-gray-200 text-gray-500 transition-colors duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                    </svg>
                </button>
            </div>

            {{-- Modal: Cuerpo --}}
            <div class="app-modal-scroll px-6 py-5 space-y-4">

                {{-- Información del cliente --}}
                <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Información del Cliente</p>
                    <div class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span id="modal-name" class="text-sm font-semibold text-gray-900"></span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <span id="modal-email" class="text-sm text-gray-600"></span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41 2 2 0 0 1 3.6 1.21h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.09 6.09l1.8-1.81a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        <span id="modal-phone" class="text-sm text-gray-600"></span>
                    </div>
                </div>

                {{-- Detalle del pedido --}}
                <div class="bg-gray-50 rounded-xl p-4">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detalle del Pedido</p>
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-2">
                            <span class="text-base">🎂</span>
                            <span id="modal-cake" class="text-sm font-semibold text-gray-900">Total pedido</span>
                        </div>
                        <span id="modal-total" class="text-sm font-bold text-gray-900"></span>
                    </div>
                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            Fecha de recogida
                        </div>
                        <span id="modal-pickup" class="text-xs font-semibold text-gray-700"></span>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                        <div class="flex items-center gap-2 text-xs text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path d="M4 11a8 8 0 0 1 8-8h8v8a8 8 0 0 1-8 8H4z"/>
                                <path d="M9 9h4"/>
                            </svg>
                            Descuento aplicado
                        </div>
                        <span id="modal-discount" class="text-xs font-semibold text-gray-700">Sin descuento</span>
                    </div>

                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Líneas del ticket</p>
                        <div id="modal-items" class="space-y-2"></div>
                    </div>
                </div>

                {{-- Estado actual --}}
                <div class="flex items-center justify-between px-1">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Estado actual</span>
                    <span id="modal-status-badge" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border"></span>
                </div>

            </div>

            {{-- Modal: Pie --}}
            <div class="px-6 py-4 border-t border-gray-100 flex justify-end">
                <button onclick="closeDetailModal()"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-medium transition-colors duration-150">
                    Cerrar
                </button>
            </div>

        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- SCRIPTS                                                      --}}
    {{-- ============================================================ --}}
    <script>
        // --------------------------------------------------------
        // CONFIRMACIÓN DE SEGURIDAD
        // Los formularios de estado crítico deben confirmarse antes
        // de enviarse al servidor. Se usa window.confirm nativo.
        // --------------------------------------------------------
        function requireConfirm(event, message) {
            if (!window.confirm(message)) {
                event.preventDefault();
                event.stopPropagation();
            }
        }

        // --------------------------------------------------------
        // MODAL DE DETALLE DEL PEDIDO
        // --------------------------------------------------------
        const detailModal = document.getElementById('detail-modal');

        function openDetailModal(btn) {
            document.getElementById('modal-id').textContent     = 'Pedido #' + btn.dataset.id;
            document.getElementById('modal-name').textContent   = btn.dataset.name;
            document.getElementById('modal-email').textContent  = btn.dataset.email;
            document.getElementById('modal-phone').textContent  = btn.dataset.phone || '—';
            document.getElementById('modal-cake').textContent   = 'Total pedido';
            document.getElementById('modal-pickup').textContent = btn.dataset.pickup;
            document.getElementById('modal-total').textContent  = btn.dataset.total + ' €';
            const discountCode = String(btn.dataset.discountCode || '').trim();
            const discountAmount = String(btn.dataset.discountAmount || '0,00').trim();
            document.getElementById('modal-discount').textContent = discountCode
                ? `${discountCode} · -${discountAmount} €`
                : (discountAmount !== '0,00' ? `Automático · -${discountAmount} €` : 'Sin descuento');

            const itemsContainer = document.getElementById('modal-items');
            let items = [];
            try {
                items = JSON.parse(btn.dataset.items || '[]');
            } catch (error) {
                items = [];
            }

            if (Array.isArray(items) && items.length > 0) {
                itemsContainer.innerHTML = items.map((item) => {
                    const qty = Number(item.quantity || 0);
                    const unitPrice = Number(item.unit_price || item.price || 0);
                    const lineTotal = Number(item.line_total || 0);
                    const size = normalizeSizeLabel(item.size ?? item.tamano ?? item.size_label ?? 'BITE');
                    const name = escapeHtml(String(item.cake_name || item.name || 'Tarta'));
                    const computedLineTotal = lineTotal > 0 ? lineTotal : (unitPrice > 0 && qty > 0 ? unitPrice * qty : 0);

                    return `<div class="flex items-center justify-between rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs">
                        <div class="min-w-0">
                            <p class="font-medium text-gray-700 truncate">${name} · ${size} · x${qty}</p>
                            <p class="text-[11px] text-gray-500">${unitPrice.toFixed(2)} € / ud</p>
                        </div>
                        <span class="font-semibold text-gray-900">${computedLineTotal.toFixed(2)} €</span>
                    </div>`;
                }).join('');
            } else {
                itemsContainer.innerHTML = '<p class="text-xs text-gray-400">Sin líneas detalladas registradas.</p>';
            }

            const badge = document.getElementById('modal-status-badge');
            badge.textContent = btn.dataset.statusLabel;
            badge.className   = 'inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold border ' + btn.dataset.statusClass;

            detailModal.style.display = 'grid';
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            detailModal.style.display = 'none';
            document.body.style.overflow = '';
        }

        // Cerrar al pulsar el fondo del overlay
        detailModal.addEventListener('click', function (e) {
            if (e.target === detailModal) {
                closeDetailModal();
            }
        });

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function normalizeSizeLabel(value) {
            const normalized = String(value || '').trim().toUpperCase();
            if (normalized === 'L' || normalized === 'PARTY') {
                return 'PARTY';
            }

            return 'BITE';
        }

        // Cerrar con la tecla Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && detailModal.style.display !== 'none') {
                closeDetailModal();
            }
        });
    </script>

</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Socios · PEQ Cakes Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @include('components.app-modal-sizing-styles')
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-500">PEQ Cakes</p>
                <h1 class="text-lg font-bold text-slate-900">Gestión de Socios</h1>
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

        <!-- Stats Summary -->
        <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total Socios</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">{{ $members->total() }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pedidos Totales</p>
                <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $members->sum('total_orders') }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Socios Activos</p>
                <p class="mt-1 text-2xl font-bold text-emerald-600">{{ $members->where('total_orders', '>', 0)->count() }}</p>
            </div>
            <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nivel Promedio</p>
                <p class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $members->where('total_orders', '>', 0)->avg('current_level') ? number_format($members->where('total_orders', '>', 0)->avg('current_level'), 1) : '—' }}
                </p>
            </div>
        </div>

        <!-- Search -->
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <form method="GET" action="{{ route('admin.members.index') }}" class="flex gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ $search }}"
                    placeholder="Buscar por nombre, email, teléfono o número de socio..."
                    class="flex-1 rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100"
                >
                <button type="submit" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white hover:bg-violet-700">
                    Buscar
                </button>
                @if($search)
                    <a href="{{ route('admin.members.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Limpiar
                    </a>
                @endif
            </form>
        </section>

        <!-- Members Table -->
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 text-left">
                        <tr>
                            <th class="px-4 py-3 font-semibold text-slate-600">
                                <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'member_number', 'dir' => $sortBy === 'member_number' && $sortDir === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    # Socio
                                    @if($sortBy === 'member_number')
                                        <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-slate-600">
                                <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'name', 'dir' => $sortBy === 'name' && $sortDir === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    Nombre
                                    @if($sortBy === 'name')
                                        <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-slate-600">Email</th>
                            <th class="px-4 py-3 font-semibold text-slate-600">Teléfono</th>
                            <th class="px-4 py-3 font-semibold text-slate-600 text-center">
                                <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'total_orders', 'dir' => $sortBy === 'total_orders' && $sortDir === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center justify-center gap-1">
                                    Pedidos
                                    @if($sortBy === 'total_orders')
                                        <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-slate-600 text-center">
                                <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'current_level', 'dir' => $sortBy === 'current_level' && $sortDir === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center justify-center gap-1">
                                    Nivel
                                    @if($sortBy === 'current_level')
                                        <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-slate-600">
                                <a href="{{ route('admin.members.index', array_merge(request()->query(), ['sort' => 'created_at', 'dir' => $sortBy === 'created_at' && $sortDir === 'asc' ? 'desc' : 'asc'])) }}" class="flex items-center gap-1">
                                    Fecha
                                    @if($sortBy === 'created_at')
                                        <span>{{ $sortDir === 'asc' ? '↑' : '↓' }}</span>
                                    @endif
                                </a>
                            </th>
                            <th class="px-4 py-3 font-semibold text-slate-600 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($members as $member)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-4 py-3 font-mono font-bold text-violet-600">#{{ str_pad($member->member_number, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="px-4 py-3 font-medium text-slate-900">{{ $member->name ?: '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $member->email ?: '—' }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $member->phone ?: '—' }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-bold text-yellow-800">
                                        {{ $member->total_orders }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($member->total_orders === 0)
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-semibold text-slate-500">Sin nivel</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-bold text-yellow-800">{{ $member->current_level }}/10</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-slate-500 text-xs">{{ $member->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.members.edit', $member) }}"
                                           class="rounded-lg bg-violet-100 px-3 py-1.5 text-xs font-semibold text-violet-700 hover:bg-violet-200 transition-colors">
                                            Editar
                                        </a>
                                        <button
                                            type="button"
                                            data-member-id="{{ $member->id }}"
                                            data-member-number="{{ $member->formattedMemberNumber }}"
                                            class="js-delete-member rounded-lg bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700 hover:bg-red-200 transition-colors">
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-12 text-center text-slate-500">
                                    No se encontraron socios.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($members->hasPages())
                <div class="border-t border-slate-200 px-4 py-3">
                    {{ $members->withQueryString()->links() }}
                </div>
            @endif
        </section>
    </main>

    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="app-modal-overlay" style="display:none; background:rgba(0,0,0,0.5); z-index:1000;">
        <div class="app-modal-dialog app-modal-dialog--compact app-modal-dialog--padded" style="background:white; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
            <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:0.5rem;">¿Eliminar socio?</h3>
            <p style="color:#64748b; font-size:0.88rem; margin-bottom:1.25rem;">
                El socio <strong id="delete-member-number"></strong> será eliminado. Esta acción no se puede deshacer.
            </p>
            <div style="display:flex; gap:0.75rem;">
                <form id="delete-form" method="POST" style="flex:1;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="width:100%; min-height:42px; border-radius:10px; background:#dc2626; color:white; font-weight:700; font-size:0.82rem; border:none; cursor:pointer;">
                        Eliminar
                    </button>
                </form>
                <button onclick="closeDeleteModal()" style="flex:1; min-height:42px; border-radius:10px; background:#f1f5f9; color:#475569; font-weight:700; font-size:0.82rem; border:1px solid #e2e8f0; cursor:pointer;">
                    Cancelar
                </button>
            </div>
        </div>
    </div>

    <script>
    function confirmDelete(memberId, memberNumber) {
        document.getElementById('delete-member-number').textContent = memberNumber;
        document.getElementById('delete-form').action = '{{ rtrim(route("admin.members.index"), "/") }}/' + memberId;
        document.getElementById('delete-modal').style.display = 'grid';
    }
    function closeDeleteModal() {
        document.getElementById('delete-modal').style.display = 'none';
    }
    document.querySelectorAll('.js-delete-member').forEach(function (button) {
        button.addEventListener('click', function () {
            confirmDelete(
                button.getAttribute('data-member-id'),
                button.getAttribute('data-member-number')
            );
        });
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
    </script>
</body>
</html>

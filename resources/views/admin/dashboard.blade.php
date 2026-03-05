<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cheesecake Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-stone-900 text-amber-50">
    <header class="border-b border-stone-800 bg-stone-900/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <h1 class="font-serif text-2xl text-amber-500">Cheesecake Studio · Admin</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-xl bg-amber-600 px-4 py-2 text-sm font-semibold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Cerrar sesión</button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-6 py-10">
        @if (session('success'))
            <div class="mb-6 rounded-xl bg-amber-600 p-4 text-white shadow-lg">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-3xl bg-stone-800 shadow-lg shadow-amber-900/20">
            <table class="min-w-full divide-y divide-stone-700">
                <thead class="bg-stone-900/70 text-left text-sm uppercase tracking-wider text-stone-300">
                    <tr>
                        <th class="px-6 py-4">Cliente</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Teléfono</th>
                        <th class="px-6 py-4">Tarta</th>
                        <th class="px-6 py-4">Estado</th>
                        <th class="px-6 py-4">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-700 text-sm text-amber-50">
                    @forelse ($orders as $order)
                        <tr>
                            <td class="px-6 py-4">{{ $order->customer_name }}</td>
                            <td class="px-6 py-4">{{ $order->customer_email }}</td>
                            <td class="px-6 py-4">{{ $order->customer_phone }}</td>
                            <td class="px-6 py-4">{{ $order->cake->name }}</td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $order->status === 'completed' ? 'bg-green-700/40 text-green-200' : 'bg-amber-700/40 text-amber-200' }}">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($order->status === 'pending')
                                    <form method="POST" action="{{ route('admin.orders.complete', $order) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded-xl bg-amber-600 px-4 py-2 text-xs font-semibold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Marcar completado</button>
                                    </form>
                                @else
                                    <span class="text-stone-400">Completado</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-stone-300">Aún no hay pedidos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Socio {{ $member->formatted_member_number }} · PEQ Cakes Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <header class="sticky top-0 z-20 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-violet-500">PEQ Cakes</p>
                <h1 class="text-lg font-bold text-slate-900">Editar Socio {{ $member->formatted_member_number }}</h1>
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

    <main class="mx-auto w-full max-w-2xl space-y-6 px-4 py-6 sm:px-6">
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Member Info Card -->
        <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="mb-6 grid grid-cols-3 gap-4">
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Pedidos</p>
                    <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $member->total_orders }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Nivel Actual</p>
                    <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $member->total_orders > 0 ? $member->current_level . '/10' : '—' }}</p>
                </div>
                <div class="text-center">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Socio desde</p>
                    <p class="mt-1 text-sm font-semibold text-slate-700">{{ $member->created_at->format('d/m/Y') }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('admin.members.update', $member) }}">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Nombre</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $member->name) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $member->email) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                    </div>

                    <div>
                        <label for="phone" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Teléfono</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone', $member->phone) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                    </div>

                    <div>
                        <label for="total_orders" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Total Pedidos</label>
                        <input id="total_orders" name="total_orders" type="number" min="0" max="99999" value="{{ old('total_orders', $member->total_orders) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                    </div>

                    <div>
                        <label for="current_level" class="mb-1 block text-xs font-semibold uppercase tracking-wide text-slate-500">Nivel (0-10)</label>
                        <input id="current_level" name="current_level" type="number" min="0" max="10" value="{{ old('current_level', $member->current_level) }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-100">
                    </div>
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="rounded-lg bg-violet-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-violet-700">
                        Guardar cambios
                    </button>
                    <a href="{{ route('admin.members.index') }}" class="rounded-lg border border-slate-300 px-6 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                        Volver
                    </a>
                </div>
            </form>
        </section>
    </main>
</body>
</html>

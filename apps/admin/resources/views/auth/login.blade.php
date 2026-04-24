<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Admin · PEQ Cakes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen antialiased text-slate-800">

    <div class="flex min-h-screen items-center justify-center px-4 py-12 sm:px-6">
        
        <div class="w-full max-w-md">
            
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8">
                
                <div class="mb-8 text-center">
                    <div class="mb-4 flex items-center justify-center gap-3">
                        <div class="w-10 h-10 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center text-xl select-none">🎂</div>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">PEQ Cakes</h1>
                    <p class="mt-1 text-sm text-gray-500">Panel de administración</p>
                </div>

                <form method="POST" action="{{ route('login.perform') }}" class="space-y-5" novalidate>
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-300 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="admin@peqcakes.com"
                        >
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Contraseña</label>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-2.5 text-gray-900 placeholder-gray-300 transition focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="••••••••"
                        >
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors duration-150">
                        Iniciar sesión
                    </button>
                </form>

                <p class="mt-6 text-center text-xs text-gray-400">Acceso restringido al equipo PEQ</p>
            </div>

        </div>

    </div>

    @include('components.cookie-consent')

</body>
</html>

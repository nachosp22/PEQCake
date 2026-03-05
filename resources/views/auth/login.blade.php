<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Cheesecake Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex min-h-screen items-center justify-center bg-[#2D1B14] px-6 text-amber-50">
    <div class="w-full max-w-md rounded-3xl bg-stone-800 p-8 shadow-lg shadow-amber-900/20">
        <h1 class="mb-6 text-center font-serif text-3xl text-amber-500">Panel Admin</h1>

        <form method="POST" action="{{ route('login.perform') }}" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="mb-2 block text-sm text-amber-50">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-3 text-amber-50 focus:border-amber-500 focus:ring-amber-500">
                @error('email')
                    <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm text-amber-50">Password</label>
                <input id="password" type="password" name="password" required class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-3 text-amber-50 focus:border-amber-500 focus:ring-amber-500">
            </div>

            <button type="submit" class="w-full rounded-xl bg-amber-600 py-3 font-semibold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Entrar</button>
        </form>
    </div>
</body>
</html>

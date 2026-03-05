<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cheesecake Studio</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-stone-900 text-amber-50 antialiased">
    <header class="sticky top-0 z-50 border-b border-stone-800 bg-stone-900/80 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <a href="#" class="font-serif text-2xl text-amber-500">Cheesecake Studio</a>
            <a href="#catalogo" class="rounded-xl bg-amber-600 px-5 py-2 font-semibold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Ver Sabores</a>
        </div>
    </header>

    <main>
        <section class="flex min-h-screen items-center">
            <div class="mx-auto grid max-w-7xl gap-12 px-6 py-20 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="mb-4 text-sm uppercase tracking-[0.25em] text-stone-300">Tartas de queso fluidas premium</p>
                    <h1 class="mb-6 font-serif text-5xl leading-tight text-amber-500 md:text-7xl">La tarta de queso que se derrite en tu boca</h1>
                    <p class="mb-10 max-w-xl text-lg text-stone-300">Textura cremosa, corazón fundente y sabores intensos diseñados para que cada corte provoque hambre instantánea.</p>
                    <a href="#catalogo" class="inline-flex rounded-2xl bg-amber-600 px-10 py-4 text-lg font-bold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Ver Sabores</a>
                </div>
                <div class="rounded-3xl border border-stone-700 bg-stone-800 p-3 shadow-lg shadow-amber-900/20">
                    <img src="https://images.unsplash.com/photo-1533134242443-d4fd215305ad?auto=format&fit=crop&w=1200&q=80" alt="Tarta de queso fluida" class="h-[420px] w-full rounded-2xl object-cover">
                </div>
            </div>
        </section>

        <section id="catalogo" class="mx-auto max-w-7xl px-6 py-20">
            <h2 class="mb-4 font-serif text-4xl text-amber-500">Catálogo de Sabores</h2>
            <p class="mb-10 text-stone-300">Elige tu favorita y prepárate para ver cómo el centro líquido se derrama al cortar.</p>

            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4">
                @foreach ($cakes as $cake)
                    <article class="overflow-hidden rounded-3xl bg-stone-800 shadow-lg shadow-amber-900/20">
                        <img src="{{ $cake->image_url }}" alt="{{ $cake->name }}" class="h-64 w-full rounded-t-3xl object-cover">
                        <div class="space-y-4 p-6">
                            <h3 class="font-serif text-2xl text-amber-500">{{ $cake->name }}</h3>
                            <p class="text-sm leading-relaxed text-stone-300">{{ $cake->description }}</p>
                            <p class="text-2xl font-bold text-amber-500">€{{ number_format($cake->price, 2) }}</p>
                            <a href="#formulario" class="inline-flex rounded-xl bg-amber-600 px-5 py-2 font-semibold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Pedir esta tarta</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>

        <section id="formulario" class="px-6 pb-20">
            <div class="mx-auto max-w-2xl rounded-3xl bg-stone-800 p-10 shadow-lg shadow-amber-900/20">
                <h2 class="mb-6 font-serif text-3xl text-amber-500">Haz tu pedido</h2>

                <form method="POST" action="{{ route('orders.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="customer_name" class="mb-2 block text-sm font-medium text-amber-50">Nombre completo</label>
                        <input id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-3 text-amber-50 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label for="customer_email" class="mb-2 block text-sm font-medium text-amber-50">Email</label>
                        <input id="customer_email" type="email" name="customer_email" value="{{ old('customer_email') }}" required class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-3 text-amber-50 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label for="customer_phone" class="mb-2 block text-sm font-medium text-amber-50">Teléfono</label>
                        <input id="customer_phone" name="customer_phone" value="{{ old('customer_phone') }}" required class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-3 text-amber-50 focus:border-amber-500 focus:ring-amber-500">
                    </div>

                    <div>
                        <label for="cake_id" class="mb-2 block text-sm font-medium text-amber-50">Elige tu tarta</label>
                        <select id="cake_id" name="cake_id" required class="w-full rounded-xl border border-stone-700 bg-stone-900 px-4 py-3 text-amber-50 focus:border-amber-500 focus:ring-amber-500">
                            <option value="">Selecciona un sabor...</option>
                            @foreach ($cakes as $cake)
                                <option value="{{ $cake->id }}" @selected((string) old('cake_id') === (string) $cake->id)>{{ $cake->name }} - €{{ number_format($cake->price, 2) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="w-full rounded-xl bg-amber-600 px-5 py-3 text-lg font-semibold text-white transition-all duration-300 hover:scale-105 hover:bg-amber-700">Enviar pedido</button>
                </form>
            </div>
        </section>
    </main>

    @if (session('success'))
        <div class="fixed bottom-4 right-4 rounded-xl bg-amber-600 p-4 text-white shadow-lg transition-all duration-300">
            {{ session('success') }}
        </div>
    @endif
</body>
</html>

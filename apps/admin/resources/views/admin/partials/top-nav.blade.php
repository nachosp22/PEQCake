@php
    $adminSections = [
        ['route' => 'admin.dashboard', 'label' => 'Pedidos'],
        ['route' => 'admin.cakes.index', 'label' => 'Tartas'],
        ['route' => 'admin.discounts.index', 'label' => 'Descuentos'],
        ['route' => 'admin.members.index', 'label' => 'Socios'],
        ['route' => 'admin.agenda.index', 'label' => 'Agenda'],
        ['route' => 'admin.reports.index', 'label' => 'Informes'],
    ];
@endphp

<nav class="flex flex-wrap items-center gap-2 text-sm">
    @foreach ($adminSections as $section)
        @if (! request()->routeIs($section['route']))
            <a
                href="{{ route($section['route']) }}"
                class="rounded-lg border border-slate-200 bg-white px-3 py-2 font-medium text-slate-600 hover:bg-slate-50"
            >
                {{ $section['label'] }}
            </a>
        @endif
    @endforeach
</nav>

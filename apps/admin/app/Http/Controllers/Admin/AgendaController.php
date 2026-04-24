<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaSetting;
use App\Models\BlockedDay;
use App\Models\BlockedWeekday;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        $agendaSetting = AgendaSetting::current();

        $blockedDays = BlockedDay::query()
            ->orderBy('date')
            ->get();

        $blockedWeekdays = BlockedWeekday::query()
            ->orderBy('weekday')
            ->pluck('weekday')
            ->map(fn (mixed $value): int => (int) $value)
            ->all();

        $weekdayOptions = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miercoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sabado',
            7 => 'Domingo',
        ];

        $minimumPickupDate = $agendaSetting->minimumPickupDate()->toDateString();

        return view('admin.agenda.index', compact('blockedDays', 'blockedWeekdays', 'weekdayOptions', 'agendaSetting', 'minimumPickupDate'));
    }

    public function updateLeadTime(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cutoff_time' => ['required', 'date_format:H:i'],
            'min_days_before_cutoff' => ['required', 'integer', 'between:1,30'],
            'min_days_after_cutoff' => ['required', 'integer', 'between:1,30'],
        ]);

        $setting = AgendaSetting::currentOrCreate();
        $setting->fill($validated);
        $setting->save();

        return redirect()->route('admin.agenda.index')->with('success', 'Reglas de anticipacion actualizadas correctamente.');
    }
}

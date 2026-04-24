<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedWeekday;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockedWeekdayController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'weekdays' => ['nullable', 'array'],
            'weekdays.*' => ['integer', 'between:1,7'],
        ]);

        $weekdays = collect($validated['weekdays'] ?? [])
            ->map(fn (mixed $value): int => (int) $value)
            ->filter(fn (int $value): bool => $value >= 1 && $value <= 7)
            ->unique()
            ->sort()
            ->values()
            ->all();

        DB::transaction(function () use ($weekdays): void {
            BlockedWeekday::query()->delete();

            foreach ($weekdays as $weekday) {
                BlockedWeekday::query()->create([
                    'weekday' => $weekday,
                ]);
            }
        });

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda semanal actualizada correctamente.');
    }
}

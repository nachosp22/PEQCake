<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedDay;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlockedDayController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'date' => ['required', 'date', 'after:today', Rule::unique('blocked_days', 'date')],
        ]);

        BlockedDay::create([
            'date' => $validated['date'],
        ]);

        return redirect()->route('admin.agenda.index')->with('success', 'Fecha bloqueada correctamente.');
    }

    public function destroy(BlockedDay $blockedDay): RedirectResponse
    {
        $blockedDay->delete();

        return redirect()->route('admin.agenda.index')->with('success', 'Fecha desbloqueada correctamente.');
    }
}

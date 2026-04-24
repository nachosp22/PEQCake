<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    private const ALLOWED_SORT_COLUMNS = [
        'member_number',
        'name',
        'total_orders',
        'current_level',
        'created_at',
    ];

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $sortBy = (string) $request->input('sort', 'created_at');
        $sortDir = strtolower((string) $request->input('dir', 'desc'));

        if (! in_array($sortBy, self::ALLOWED_SORT_COLUMNS, true)) {
            $sortBy = 'created_at';
        }

        if (! in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        $members = Member::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($q) use ($search): void {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('email', 'LIKE', '%' . $search . '%')
                        ->orWhere('phone', 'LIKE', '%' . $search . '%')
                        ->orWhere('member_number', 'LIKE', '%' . $search . '%');
                });
            })
            ->orderBy($sortBy, $sortDir)
            ->paginate(20)
            ->withQueryString();

        return view('admin.members.index', [
            'members' => $members,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ]);
    }

    public function edit(Member $member): View
    {
        return view('admin.members.edit', [
            'member' => $member,
        ]);
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:members,email,' . $member->id],
            'phone' => ['nullable', 'string', 'max:32'],
            'total_orders' => ['nullable', 'integer', 'min:0', 'max:99999'],
            'current_level' => ['nullable', 'integer', 'min:0', 'max:10'],
        ]);

        // Si se actualiza total_orders, recalcular nivel automáticamente
        if (isset($validated['total_orders'])) {
            $validated['current_level'] = Member::calculateLevel((int) $validated['total_orders']);
        } elseif (isset($validated['current_level'])) {
            // Si solo se actualiza nivel manualmente, ajustar total_orders al nivel
            // Esto permite al admin corregir niveles manualmente
            $validated['total_orders'] = $validated['current_level'];
        }

        $member->update($validated);

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Socio actualizado correctamente.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $member->delete();

        return redirect()
            ->route('admin.members.index')
            ->with('success', 'Socio eliminado correctamente.');
    }
}

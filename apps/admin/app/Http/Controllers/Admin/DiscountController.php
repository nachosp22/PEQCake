<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Models\Discount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DiscountController extends Controller
{
    public function index(Request $request): View
    {
        $query = Discount::query()->latest('id');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($subQuery) use ($search): void {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('discount_type')) {
            if ($request->input('discount_type') === 'code') {
                $query->where('is_automatic', false);
            }

            if ($request->input('discount_type') === 'automatic') {
                $query->where('is_automatic', true);
            }
        }

        if ($request->filled('state')) {
            if ($request->input('state') === 'active') {
                $query->where('is_active', true);
            }

            if ($request->input('state') === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $discounts = $query->get();

        return view('admin.discounts.index', compact('discounts'));
    }

    public function store(StoreDiscountRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Discount::create($this->payload($validated));

        return back()->with('success', 'Descuento creado correctamente.');
    }

    public function update(StoreDiscountRequest $request, Discount $discount): RedirectResponse
    {
        $validated = $request->validated();
        $discount->update($this->payload($validated));

        return back()->with('success', 'Descuento actualizado correctamente.');
    }

    public function toggleActive(Discount $discount): RedirectResponse
    {
        $discount->update(['is_active' => ! $discount->is_active]);

        $message = $discount->is_active
            ? 'Descuento activado.'
            : 'Descuento desactivado.';

        return back()->with('success', $message);
    }

    public function destroy(Discount $discount): RedirectResponse
    {
        $discount->delete();

        return back()->with('success', 'Descuento eliminado.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function payload(array $validated): array
    {
        return [
            'name' => $validated['name'],
            'code' => ($validated['discount_type'] ?? 'code') === 'code'
                ? $validated['code']
                : null,
            'is_automatic' => ($validated['discount_type'] ?? 'code') === 'automatic',
            'value_type' => $validated['value_type'],
            'value' => $validated['value'],
            'min_subtotal' => $validated['min_order_amount'] ?? null,
            'starts_at' => $validated['starts_at'] ?? null,
            'ends_at' => $validated['ends_at'] ?? null,
            'max_uses' => $validated['max_uses'] ?? null,
            'times_used' => $validated['times_used'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ];
    }
}

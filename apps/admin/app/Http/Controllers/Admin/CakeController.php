<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCakeRequest;
use App\Models\Cake;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CakeController extends Controller
{
    private const ALLERGEN_FIELDS = [
        'allergen_milk',
        'allergen_eggs',
        'allergen_gluten',
        'allergen_nuts',
        'allergen_soy',
        'allergen_sulfites',
    ];

    public function index(Request $request): View
    {
        $query = Cake::query()->withTrashed()->orderBy('sort_order')->orderBy('name');

        if ($request->filled('search')) {
            $search = trim((string) $request->input('search'));
            $query->where(function ($subQuery) use ($search): void {
                $subQuery->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            match ($request->input('status')) {
                'available' => $query->where('is_available', true)->whereNull('deleted_at'),
                'unavailable' => $query->where('is_available', false)->whereNull('deleted_at'),
                'deleted' => $query->onlyTrashed(),
                default => null,
            };
        }

        $cakes = $query->get();

        return view('admin.cakes.index', compact('cakes'));
    }

    public function store(StoreCakeRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Cake::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'price_s' => $validated['price_s'],
            'price_l' => $validated['price_l'],
            'price' => $validated['price_s'],
            'is_available' => (bool) ($validated['is_available'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
            ...$this->allergenPayload($validated),
        ]);

        return back()->with('success', 'Tarta creada correctamente.');
    }

    public function update(StoreCakeRequest $request, Cake $cake): RedirectResponse
    {
        $validated = $request->validated();

        $cake->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'price_s' => $validated['price_s'],
            'price_l' => $validated['price_l'],
            'price' => $validated['price_s'],
            'is_available' => (bool) ($validated['is_available'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
            ...$this->allergenPayload($validated),
        ]);

        return back()->with('success', 'Tarta actualizada correctamente.');
    }

    public function destroy(Cake $cake): RedirectResponse
    {
        if ($cake->trashed()) {
            return back()->with('success', 'La tarta ya estaba eliminada.');
        }

        $cake->delete();

        return back()->with('success', 'Tarta eliminada (soft-delete).');
    }

    public function restore(Cake $cake): RedirectResponse
    {
        if ($cake->trashed()) {
            $cake->restore();
        }

        return back()->with('success', 'Tarta restaurada correctamente.');
    }

    /**
     * @param  array<string, mixed>  $validated
     * @return array<string, bool>
     */
    private function allergenPayload(array $validated): array
    {
        $payload = [];

        foreach (self::ALLERGEN_FIELDS as $field) {
            $payload[$field] = (bool) ($validated[$field] ?? false);
        }

        return $payload;
    }
}

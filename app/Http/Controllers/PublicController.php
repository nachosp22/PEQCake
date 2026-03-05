<?php

namespace App\Http\Controllers;

use App\Models\Cake;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function index(): View
    {
        $cakes = Cake::query()
            ->where('is_available', true)
            ->orderBy('name')
            ->get();

        return view('welcome', compact('cakes'));
    }

    public function storeOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'cake_id' => [
                'required',
                Rule::exists('cakes', 'id')->where(fn ($query) => $query->where('is_available', true)),
            ],
        ]);

        Order::create($validated);

        return redirect('/')
            ->with('success', '¡Pedido en el horno! Nos pondremos en contacto contigo.');
    }
}

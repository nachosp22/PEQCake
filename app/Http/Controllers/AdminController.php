<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $orders = Order::with('cake')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('orders'));
    }

    public function complete(Order $order): RedirectResponse
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'completed']);
        }

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}

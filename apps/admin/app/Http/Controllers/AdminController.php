<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmation;
use App\Mail\PaymentConfirmation;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $query = Order::with('cake')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', '%'.$search.'%')
                    ->orWhere('customer_email', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('date_from') && preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->date_from)) {
            $query->whereDate('pickup_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to') && preg_match('/^\d{4}-\d{2}-\d{2}$/', $request->date_to)) {
            $query->whereDate('pickup_date', '<=', $request->date_to);
        }

        $validStatuses = ['pending', 'confirmed', 'paid', 'completed', 'cancelled'];
        if ($request->filled('status') && in_array($request->status, $validStatuses)) {
            $query->where('status', $request->status);
        }

        $orders = $query->get()->map(function (Order $order): Order {
            $normalizedItems = $order->normalizedItemsForAdmin();

            $order->setAttribute('items_admin', $normalizedItems);
            $order->setAttribute('items_admin_count', count($normalizedItems));
            $order->setAttribute('items_admin_total_quantity', collect($normalizedItems)->sum('quantity'));

            return $order;
        });

        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'paid' => Order::where('status', 'paid')->count(),
        ];

        return view('admin.dashboard', compact('orders', 'stats'));
    }

    public function complete(Order $order): RedirectResponse
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'completed']);
        }

        return back()->with('success', 'Estado del pedido actualizado.');
    }

    public function confirm(Order $order): RedirectResponse
    {
        if ($order->status === 'pending') {
            $order->update(['status' => 'confirmed']);
            
            // Enviar email de confirmación al cliente
            Mail::to($order->customer_email)->send(new OrderConfirmation($order));
        }

        return back()->with('success', "Pedido #{$order->id} marcado como Confirmado.");
    }

    public function pay(Order $order): RedirectResponse
    {
        if (in_array($order->status, ['pending', 'confirmed'])) {
            $order->update(['status' => 'paid']);
            
            // Enviar email de confirmación de pago
            Mail::to($order->customer_email)->send(new PaymentConfirmation($order));
        }

        return back()->with('success', "Pedido #{$order->id} marcado como Pagado.");
    }
}

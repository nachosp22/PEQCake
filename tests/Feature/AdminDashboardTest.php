<?php

namespace Tests\Feature;

use App\Models\Cake;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_routes_require_authentication(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_complete_pending_order(): void
    {
        $admin = User::factory()->create();

        $cake = Cake::create([
            'name' => 'Admin Cake',
            'description' => 'Cream center',
            'price' => 28,
            'is_available' => true,
        ]);

        $order = Order::create([
            'cake_id' => $cake->id,
            'customer_name' => 'Cliente Admin',
            'customer_email' => 'admin-client@example.com',
            'customer_phone' => '611111111',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.orders.complete', $order));

        $response->assertRedirect();
        $this->assertDatabaseHas(Order::class, [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }
}

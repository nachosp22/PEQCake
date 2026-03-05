<?php

namespace Tests\Feature;

use App\Models\Cake;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_shows_only_available_cakes(): void
    {
        $availableCake = Cake::create([
            'name' => 'Visible Cake',
            'description' => 'Creamy',
            'price' => 10,
            'is_available' => true,
        ]);

        Cake::create([
            'name' => 'Hidden Cake',
            'description' => 'Hidden',
            'price' => 20,
            'is_available' => false,
        ]);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee($availableCake->name);
        $response->assertDontSee('Hidden Cake');
    }

    public function test_customer_can_store_order(): void
    {
        $cake = Cake::create([
            'name' => 'Order Cake',
            'description' => 'Flowing center',
            'price' => 35,
            'is_available' => true,
        ]);

        $response = $this->post('/order', [
            'customer_name' => 'Cliente Demo',
            'customer_email' => 'cliente@example.com',
            'customer_phone' => '600123123',
            'cake_id' => $cake->id,
        ]);

        $response->assertRedirect('/');
        $response->assertSessionHas('success');

        $this->assertDatabaseHas(Order::class, [
            'customer_name' => 'Cliente Demo',
            'cake_id' => $cake->id,
            'status' => 'pending',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\AgendaSetting;
use App\Models\BlockedDay;
use App\Models\BlockedWeekday;
use App\Models\Cake;
use App\Models\Discount;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublicControllerTest extends TestCase
{
    use RefreshDatabase;

    private const ORDER_PROCESSING_MESSAGE = 'Estamos procesando tu pedido. En breves recibirás un correo confirmando el pedido y con los métodos de pago disponibles. Gracias por confiar en PEQCakes.';

    public function test_home_shows_only_available_cakes(): void
    {
        $availableCake = Cake::create([
            'name' => 'Visible Cake',
            'description' => 'Creamy',
            'price' => 10,
            'price_s' => 10,
            'price_l' => 14,
            'is_available' => true,
            'allergen_gluten' => true,
            'allergen_milk' => true,
        ]);

        Cake::create([
            'name' => 'Hidden Cake',
            'description' => 'Hidden',
            'price' => 20,
            'is_available' => false,
        ]);

        $response = $this->get(route('store.home'));

        $response->assertOk();
        $response->assertSee($availableCake->name);
        $response->assertDontSee('Hidden Cake');
        $response->assertSee('data-open-cake-modal', false);
        $response->assertSee('id="cake-detail-modal"', false);
        $response->assertSee('id="cake-modal-add-btn"', false);
        $response->assertDontSee('id="cake-modal-order-btn"', false);
        $response->assertDontSee('Ir a pedido');
        $response->assertSee('data-modal-size="BITE"', false);
        $response->assertSee('data-modal-size="PARTY"', false);
        $response->assertSee('function addCakeToTicket', false);
        $response->assertSee('id="cake-modal-qty"', false);
        $response->assertSee('addCakeToTicket(cake.id, selectedSize, selectedQuantity);', false);
        $response->assertSee('addCakeToTicket(cakeId, size, quantity);', false);
        $response->assertSee("showToast('Tarta añadida con éxito.');", false);
        $response->assertSee('id="toast-stack"', false);
        $response->assertSee('id="flash-success-json"', false);
        $response->assertSee('milk.svg', false);
        $response->assertSee('egg.svg', false);
        $response->assertSee('gluten.svg', false);
        $response->assertSee('fsecos.svg', false);
        $response->assertSee('soja.svg', false);
        $response->assertSee('sulfitos.svg', false);
        $response->assertSee('allergen_gluten', false);
        $response->assertSee('Leche', false);
        $response->assertSee('Gluten', false);
    }

    public function test_customer_can_store_order(): void
    {
        $cakeA = Cake::create([
            'name' => 'Order Cake A',
            'description' => 'Flowing center',
            'price' => 35,
            'is_available' => true,
        ]);

        $cakeB = Cake::create([
            'name' => 'Order Cake B',
            'description' => 'Salted caramel',
            'price' => 42,
            'is_available' => true,
        ]);

        $response = $this->post('/order', [
            'customer_name' => 'Cliente Demo',
            'customer_email' => 'cliente@example.com',
            'customer_phone' => '600123123',
            'delivery_date' => $this->validDeliveryDate(),
            'notes' => 'Sin frutos secos',
            'cake_id' => $cakeA->id,
            'pedido' => [
                ['cake_id' => $cakeA->id, 'size' => 'BITE', 'quantity' => 2],
                ['cake_id' => $cakeB->id, 'size' => 'PARTY', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHas('success', self::ORDER_PROCESSING_MESSAGE);

        $this->assertDatabaseHas(Order::class, [
            'customer_name' => 'Cliente Demo',
            'cake_id' => $cakeA->id,
            'status' => 'pending',
        ]);

        $order = Order::query()->firstOrFail();
        $this->assertNotEmpty($order->items);
        $this->assertCount(2, $order->items);
        $this->assertSame('Order Cake A', $order->items[0]['cake_name']);
        $this->assertSame('BITE', $order->items[0]['size']);
        $this->assertSame('PARTY', $order->items[1]['size']);
        $this->assertSame('Sin frutos secos', $order->notes);
        $this->assertSame(112.0, (float) $order->total);
    }

    public function test_customer_can_store_order_with_legacy_size_aliases_and_they_are_canonicalized(): void
    {
        $cake = Cake::create([
            'name' => 'Legacy Size Cake',
            'description' => 'Legacy alias acceptance',
            'price' => 20,
            'price_s' => 18,
            'price_l' => 30,
            'is_available' => true,
        ]);

        $response = $this->post('/order', [
            'customer_name' => 'Cliente Legacy',
            'customer_email' => 'legacy@example.com',
            'customer_phone' => '600123124',
            'delivery_date' => $this->validDeliveryDate(),
            'cake_id' => $cake->id,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
                ['cake_id' => $cake->id, 'size' => 'L', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));

        $order = Order::query()->firstOrFail();
        $this->assertSame('BITE', $order->items[0]['size']);
        $this->assertSame('PARTY', $order->items[1]['size']);
        $this->assertSame(48.0, (float) $order->total);
    }

    public function test_home_renders_order_processing_flash_message_payload(): void
    {
        $response = $this
            ->withSession(['success' => self::ORDER_PROCESSING_MESSAGE])
            ->get(route('store.home'));

        $response->assertOk();
        $response->assertSee('id="flash-success-json"', false);
        $response->assertSee('Estamos procesando tu pedido', false);
        $response->assertSee('showToast(flashSuccessMessage);', false);
    }

    public function test_customer_cannot_store_order_without_ticket_items(): void
    {
        $response = $this->from(route('store.home'))->post('/order', [
            'customer_name' => 'Cliente Demo',
            'customer_email' => 'cliente@example.com',
            'customer_phone' => '600123123',
            'delivery_date' => $this->validDeliveryDate(),
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHasErrors('pedido');
        $this->assertDatabaseCount(Order::class, 0);
    }

    public function test_customer_cannot_store_order_for_today(): void
    {
        $cake = Cake::create([
            'name' => 'Today Cake',
            'description' => 'Today rule',
            'price' => 20,
            'is_available' => true,
        ]);

        $response = $this->from(route('store.home'))->post('/order', [
            'customer_name' => 'Cliente Hoy',
            'customer_email' => 'hoy@example.com',
            'customer_phone' => '600555555',
            'delivery_date' => now()->toDateString(),
            'cake_id' => $cake->id,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHasErrors('delivery_date');
        $this->assertDatabaseCount(Order::class, 0);
    }

    public function test_customer_can_store_order_next_day_when_before_cutoff_rule_applies(): void
    {
        AgendaSetting::create([
            'cutoff_time' => '23:59',
            'min_days_before_cutoff' => 1,
            'min_days_after_cutoff' => 2,
        ]);

        $cake = Cake::create([
            'name' => 'Before Cutoff Cake',
            'description' => 'Before cutoff rule',
            'price' => 20,
            'is_available' => true,
        ]);

        $response = $this->post('/order', [
            'customer_name' => 'Cliente Antes',
            'customer_email' => 'antes@example.com',
            'customer_phone' => '600123000',
            'delivery_date' => now()->addDay()->toDateString(),
            'cake_id' => $cake->id,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHasNoErrors();
    }

    public function test_customer_cannot_store_order_next_day_when_after_cutoff_rule_applies(): void
    {
        AgendaSetting::create([
            'cutoff_time' => '00:00',
            'min_days_before_cutoff' => 1,
            'min_days_after_cutoff' => 2,
        ]);

        $cake = Cake::create([
            'name' => 'After Cutoff Cake',
            'description' => 'After cutoff rule',
            'price' => 20,
            'is_available' => true,
        ]);

        $response = $this->from(route('store.home'))->post('/order', [
            'customer_name' => 'Cliente Despues',
            'customer_email' => 'despues@example.com',
            'customer_phone' => '600123001',
            'delivery_date' => now()->addDay()->toDateString(),
            'cake_id' => $cake->id,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHasErrors('delivery_date');
        $this->assertDatabaseCount(Order::class, 0);
    }

    public function test_customer_cannot_store_order_for_blocked_day(): void
    {
        $cake = Cake::create([
            'name' => 'Blocked Day Cake',
            'description' => 'Blocked day rule',
            'price' => 20,
            'is_available' => true,
        ]);

        $blockedDate = now()->addDays(2)->toDateString();
        BlockedDay::create(['date' => $blockedDate]);

        $response = $this->from(route('store.home'))->post('/order', [
            'customer_name' => 'Cliente Bloqueado',
            'customer_email' => 'bloqueado@example.com',
            'customer_phone' => '600555556',
            'delivery_date' => $blockedDate,
            'cake_id' => $cake->id,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHasErrors('delivery_date');
        $this->assertDatabaseCount(Order::class, 0);
    }

    public function test_customer_cannot_store_order_for_blocked_weekday(): void
    {
        $cake = Cake::create([
            'name' => 'Blocked Weekday Cake',
            'description' => 'Blocked weekday rule',
            'price' => 20,
            'is_available' => true,
        ]);

        BlockedWeekday::create(['weekday' => 1]);

        $nextMonday = now()->next('Monday')->toDateString();

        $response = $this->from(route('store.home'))->post('/order', [
            'customer_name' => 'Cliente Lunes',
            'customer_email' => 'lunes@example.com',
            'customer_phone' => '600555557',
            'delivery_date' => $nextMonday,
            'cake_id' => $cake->id,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertSessionHasErrors('delivery_date');
        $this->assertDatabaseCount(Order::class, 0);
    }

    public function test_home_includes_future_blocked_dates_for_client_date_picker(): void
    {
        $pastDate = now()->subDay()->toDateString();
        $futureDate = now()->addDays(3)->toDateString();

        BlockedDay::create(['date' => $pastDate]);
        BlockedDay::create(['date' => $futureDate]);

        $response = $this->get(route('store.home'));

        $response->assertOk();
        $response->assertSee('id="blocked-dates-json"', false);
        $response->assertSee($futureDate, false);
        $response->assertDontSee($pastDate, false);
    }

    public function test_home_includes_blocked_weekdays_for_client_date_picker(): void
    {
        BlockedWeekday::create(['weekday' => 1]);
        BlockedWeekday::create(['weekday' => 6]);

        $response = $this->get(route('store.home'));

        $response->assertOk();
        $response->assertSee('id="blocked-weekdays-json"', false);
        $response->assertSee('[1,6]', false);
    }

    public function test_checkout_applies_best_single_discount_between_code_and_automatic(): void
    {
        $cake = Cake::create([
            'name' => 'Discount Cake',
            'description' => 'Discount test',
            'price' => 100,
            'is_available' => true,
        ]);

        Discount::create([
            'name' => 'Code 10',
            'code' => 'SAVE10',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 10,
            'is_active' => true,
        ]);

        Discount::create([
            'name' => 'Auto 20',
            'code' => null,
            'is_automatic' => true,
            'value_type' => 'fixed',
            'value' => 20,
            'is_active' => true,
        ]);

        $this->post('/order', $this->orderPayload($cake, 'SAVE10'))->assertRedirect(route('store.home'));

        $order = Order::query()->firstOrFail();
        $this->assertSame('pending', $order->status);
        $this->assertSame(80.0, (float) $order->total);
        $this->assertSame(20.0, (float) $order->discount_amount);
        $this->assertNull($order->discount_code);
    }

    public function test_single_use_code_is_consumed_and_unavailable_for_next_order(): void
    {
        $cake = Cake::create([
            'name' => 'One Use Cake',
            'description' => 'One use',
            'price' => 100,
            'is_available' => true,
        ]);

        $discount = Discount::create([
            'name' => 'One use 15',
            'code' => 'ONCE15',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 15,
            'max_uses' => 1,
            'times_used' => 0,
            'is_active' => true,
        ]);

        $this->post('/order', $this->orderPayload($cake, 'ONCE15'))->assertRedirect(route('store.home'));

        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);

        $this->post('/order', $this->orderPayload($cake, 'ONCE15'))->assertRedirect(route('store.home'));

        $orders = Order::query()->orderBy('id')->get();
        $this->assertCount(2, $orders);

        $this->assertSame(85.0, (float) $orders[0]->total);
        $this->assertSame(15.0, (float) $orders[0]->discount_amount);
        $this->assertSame('ONCE15', $orders[0]->discount_code);

        $this->assertSame(100.0, (float) $orders[1]->total);
        $this->assertSame(0.0, (float) $orders[1]->discount_amount);
        $this->assertNull($orders[1]->discount_code);
    }

    public function test_checkout_falls_back_to_automatic_when_code_becomes_unavailable(): void
    {
        $cake = Cake::create([
            'name' => 'Fallback Cake',
            'description' => 'Fallback',
            'price' => 100,
            'is_available' => true,
        ]);

        Discount::create([
            'name' => 'Single use code 15',
            'code' => 'ONCE15',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 15,
            'max_uses' => 1,
            'times_used' => 0,
            'is_active' => true,
        ]);

        Discount::create([
            'name' => 'Automatic 10',
            'code' => null,
            'is_automatic' => true,
            'value_type' => 'fixed',
            'value' => 10,
            'is_active' => true,
        ]);

        $this->post('/order', $this->orderPayload($cake, 'ONCE15'))->assertRedirect(route('store.home'));
        $this->post('/order', $this->orderPayload($cake, 'ONCE15'))->assertRedirect(route('store.home'));

        $orders = Order::query()->orderBy('id')->get();
        $this->assertCount(2, $orders);

        $this->assertSame(85.0, (float) $orders[0]->total);
        $this->assertSame('ONCE15', $orders[0]->discount_code);
        $this->assertSame(15.0, (float) $orders[0]->discount_amount);

        $this->assertSame(90.0, (float) $orders[1]->total);
        $this->assertNull($orders[1]->discount_code);
        $this->assertSame(10.0, (float) $orders[1]->discount_amount);
    }

    public function test_home_uses_single_cakes_select_query_even_with_larger_catalog(): void
    {
        Cake::create([
            'name' => 'Catalog Base Cake',
            'description' => 'Base',
            'price' => 20,
            'is_available' => true,
        ]);

        $singleCatalogCakeQueries = $this->countCakeSelectQueriesDuring(fn () => $this->get(route('store.home'))->assertOk());

        for ($i = 1; $i <= 8; $i++) {
            Cake::create([
                'name' => 'Catalog Cake '.$i,
                'description' => 'Catalog '.$i,
                'price' => 20 + $i,
                'is_available' => true,
            ]);
        }

        $largerCatalogCakeQueries = $this->countCakeSelectQueriesDuring(fn () => $this->get(route('store.home'))->assertOk());

        $this->assertSame(1, $singleCatalogCakeQueries);
        $this->assertSame(1, $largerCatalogCakeQueries);
    }

    public function test_order_checkout_avoids_per_item_cake_select_queries(): void
    {
        $cakeA = Cake::create([
            'name' => 'Query Cake A',
            'description' => 'Query A',
            'price' => 35,
            'is_available' => true,
        ]);

        $cakeB = Cake::create([
            'name' => 'Query Cake B',
            'description' => 'Query B',
            'price' => 42,
            'is_available' => true,
        ]);

        $singleItemCakeQueries = $this->countCakeSelectQueriesDuring(function () use ($cakeA): void {
            $this->post('/order', [
                'customer_name' => 'Cliente Query',
                'customer_email' => 'query@example.com',
                'customer_phone' => '600111222',
                'delivery_date' => $this->validDeliveryDate(),
                'cake_id' => $cakeA->id,
                'pedido' => [
                    ['cake_id' => $cakeA->id, 'size' => 'BITE', 'quantity' => 1],
                ],
            ])->assertRedirect(route('store.home'));
        });

        $multiItemCakeQueries = $this->countCakeSelectQueriesDuring(function () use ($cakeA, $cakeB): void {
            $this->post('/order', [
                'customer_name' => 'Cliente Query',
                'customer_email' => 'query@example.com',
                'customer_phone' => '600111222',
                'delivery_date' => $this->validDeliveryDate(),
                'cake_id' => $cakeA->id,
                'pedido' => [
                    ['cake_id' => $cakeA->id, 'size' => 'BITE', 'quantity' => 2],
                    ['cake_id' => $cakeB->id, 'size' => 'PARTY', 'quantity' => 1],
                ],
            ])->assertRedirect(route('store.home'));
        });

        $this->assertSame($singleItemCakeQueries, $multiItemCakeQueries);
        $this->assertGreaterThanOrEqual(1, $multiItemCakeQueries);
    }

    public function test_order_snapshot_fields_are_preserved_after_discount_row_is_deleted(): void
    {
        $cake = Cake::create([
            'name' => 'Snapshot Cake',
            'description' => 'Snapshot',
            'price' => 100,
            'is_available' => true,
        ]);

        $discount = Discount::create([
            'name' => 'Snapshot single use 12',
            'code' => 'SNAP12',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 12,
            'max_uses' => 1,
            'times_used' => 0,
            'is_active' => true,
        ]);

        $this->post('/order', $this->orderPayload($cake, 'SNAP12'))->assertRedirect(route('store.home'));

        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);

        $order = Order::query()->firstOrFail();
        $this->assertSame('SNAP12', $order->discount_code);
        $this->assertSame(12.0, (float) $order->discount_amount);
        $this->assertSame(88.0, (float) $order->total);
    }

    public function test_preview_discount_returns_reduced_total_for_valid_code(): void
    {
        $cake = Cake::create([
            'name' => 'Preview Cake',
            'description' => 'Preview',
            'price' => 100,
            'is_available' => true,
        ]);

        Discount::create([
            'name' => 'Preview 10',
            'code' => 'PREVIEW10',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 10,
            'is_active' => true,
        ]);

        $response = $this->postJson('/discounts/preview', [
            'discount_code' => 'PREVIEW10',
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('status', 'applied')
            ->assertJsonPath('subtotal', 100)
            ->assertJsonPath('discount_amount', 10)
            ->assertJsonPath('total', 90)
            ->assertJsonPath('discount.code', 'PREVIEW10');

        $response->assertJsonStructure([
            'success',
            'status',
            'discount' => ['id', 'name', 'code', 'value_type', 'value'],
            'subtotal',
            'discount_amount',
            'total',
            'message',
            'items_count',
        ]);
    }

    public function test_preview_discount_returns_error_for_invalid_code_with_unchanged_total(): void
    {
        $cake = Cake::create([
            'name' => 'Invalid Preview Cake',
            'description' => 'Invalid',
            'price' => 75,
            'is_available' => true,
        ]);

        $response = $this->postJson('/discounts/preview', [
            'discount_code' => 'NOTREAL',
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('success', false)
            ->assertJsonPath('status', 'invalid')
            ->assertJsonPath('subtotal', 75)
            ->assertJsonPath('discount_amount', 0)
            ->assertJsonPath('total', 75);
    }

    public function test_preview_discount_returns_expired_status_for_expired_code(): void
    {
        $cake = Cake::create([
            'name' => 'Expired Preview Cake',
            'description' => 'Expired',
            'price' => 80,
            'is_available' => true,
        ]);

        Discount::create([
            'name' => 'Expired Code',
            'code' => 'OLD20',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 20,
            'is_active' => true,
            'ends_at' => now()->subDay(),
        ]);

        $response = $this->postJson('/discounts/preview', [
            'discount_code' => 'OLD20',
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('success', false)
            ->assertJsonPath('status', 'expired')
            ->assertJsonPath('total', 80);
    }

    public function test_preview_discount_returns_consumed_status_when_usage_limit_reached(): void
    {
        $cake = Cake::create([
            'name' => 'Consumed Preview Cake',
            'description' => 'Consumed',
            'price' => 120,
            'is_available' => true,
        ]);

        Discount::create([
            'name' => 'Consumed Code',
            'code' => 'FULLYUSED',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 12,
            'is_active' => true,
            'max_uses' => 2,
            'times_used' => 2,
        ]);

        $response = $this->postJson('/discounts/preview', [
            'discount_code' => 'FULLYUSED',
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('success', false)
            ->assertJsonPath('status', 'consumed')
            ->assertJsonPath('discount_amount', 0)
            ->assertJsonPath('total', 120);
    }

    public function test_preview_discount_returns_min_subtotal_not_met_when_cart_is_too_low(): void
    {
        $cake = Cake::create([
            'name' => 'Min Subtotal Cake',
            'description' => 'Min',
            'price' => 30,
            'is_available' => true,
        ]);

        Discount::create([
            'name' => 'Min 50',
            'code' => 'MIN50',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 5,
            'is_active' => true,
            'min_subtotal' => 50,
        ]);

        $response = $this->postJson('/discounts/preview', [
            'discount_code' => 'MIN50',
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ]);

        $response->assertOk()
            ->assertJsonPath('success', false)
            ->assertJsonPath('status', 'min_subtotal_not_met')
            ->assertJsonPath('subtotal', 30)
            ->assertJsonPath('discount_amount', 0)
            ->assertJsonPath('total', 30);
    }

    /**
     * @return array<string, mixed>
     */
    private function orderPayload(Cake $cake, ?string $discountCode = null): array
    {
        return [
            'customer_name' => 'Cliente Demo',
            'customer_email' => 'cliente@example.com',
            'customer_phone' => '600123123',
            'delivery_date' => $this->validDeliveryDate(),
            'cake_id' => $cake->id,
            'discount_code' => $discountCode,
            'pedido' => [
                ['cake_id' => $cake->id, 'size' => 'BITE', 'quantity' => 1],
            ],
        ];
    }

    private function validDeliveryDate(): string
    {
        return AgendaSetting::current()->minimumPickupDate()->toDateString();
    }

    private function countCakeSelectQueriesDuring(callable $callback): int
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $callback();

        /** @var array<int, array{query:string}> $queries */
        $queries = DB::getQueryLog();

        DB::disableQueryLog();

        return collect($queries)
            ->filter(function (array $query): bool {
                $sql = strtolower((string) ($query['query'] ?? ''));

                return str_contains($sql, 'select')
                    && (str_contains($sql, 'from "cakes"') || str_contains($sql, 'from `cakes`'));
            })
            ->count();
    }
}

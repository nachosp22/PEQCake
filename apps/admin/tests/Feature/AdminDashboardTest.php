<?php

namespace Tests\Feature;

use App\Models\AgendaSetting;
use App\Models\BlockedDay;
use App\Models\BlockedWeekday;
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
        $adminPath = '/'.trim((string) config('peq.admin_path'), '/');

        $this->get($adminPath)->assertRedirect($adminPath.'/login');
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
            'items' => [[
                'cake_id' => $cake->id,
                'cake_name' => $cake->name,
                'size' => 'BITE',
                'quantity' => 1,
                'unit_price' => 28,
                'line_total' => 28,
            ]],
            'customer_name' => 'Cliente Admin',
            'customer_email' => 'admin-client@example.com',
            'customer_phone' => '611111111',
            'pickup_date' => now()->addDay()->toDateString(),
            'total' => 28,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.orders.complete', $order));

        $response->assertRedirect();
        $this->assertDatabaseHas(Order::class, [
            'id' => $order->id,
            'status' => 'completed',
        ]);
    }

    public function test_admin_dashboard_includes_all_multi_item_lines_in_detail_payload(): void
    {
        $admin = User::factory()->create();

        $cakeA = Cake::create([
            'name' => 'Multi Cake A',
            'description' => 'A',
            'price' => 28,
            'is_available' => true,
        ]);

        $cakeB = Cake::create([
            'name' => 'Multi Cake B',
            'description' => 'B',
            'price' => 34,
            'is_available' => true,
        ]);

        Order::create([
            'cake_id' => $cakeA->id,
            'items' => [
                [
                    'cake_id' => $cakeA->id,
                    'cake_name' => $cakeA->name,
                    'size' => 'BITE',
                    'quantity' => 2,
                    'unit_price' => 28,
                    'line_total' => 56,
                ],
                [
                    'cake_id' => $cakeB->id,
                    'cake_name' => $cakeB->name,
                    'size' => 'PARTY',
                    'quantity' => 1,
                    'unit_price' => 34,
                    'line_total' => 34,
                ],
            ],
            'customer_name' => 'Cliente Multi',
            'customer_email' => 'multi@example.com',
            'customer_phone' => '611111112',
            'pickup_date' => now()->addDay()->toDateString(),
            'total' => 90,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Multi Cake A', false);
        $response->assertSee('Multi Cake B', false);
        $response->assertSee('2 líneas / 3 uds', false);
        $response->assertSee('data-items=', false);
        $response->assertSee('&quot;cake_name&quot;:&quot;Multi Cake A&quot;', false);
        $response->assertSee('&quot;size&quot;:&quot;BITE&quot;', false);
        $response->assertSee('&quot;quantity&quot;:2', false);
        $response->assertSee('&quot;unit_price&quot;:28', false);
        $response->assertSee('&quot;line_total&quot;:56', false);
        $response->assertSee('&quot;cake_name&quot;:&quot;Multi Cake B&quot;', false);
        $response->assertSee('&quot;size&quot;:&quot;PARTY&quot;', false);
        $response->assertSee('&quot;quantity&quot;:1', false);
        $response->assertSee('&quot;unit_price&quot;:34', false);
        $response->assertSee('&quot;line_total&quot;:34', false);
    }

    public function test_admin_dashboard_shows_discount_code_and_amount_in_order_list_and_detail_payload(): void
    {
        $admin = User::factory()->create();

        $cake = Cake::create([
            'name' => 'Discount Admin Cake',
            'description' => 'A',
            'price' => 30,
            'is_available' => true,
        ]);

        Order::create([
            'cake_id' => $cake->id,
            'items' => [[
                'cake_id' => $cake->id,
                'cake_name' => $cake->name,
                'size' => 'BITE',
                'quantity' => 1,
                'unit_price' => 30,
                'line_total' => 30,
            ]],
            'customer_name' => 'Cliente Discount',
            'customer_email' => 'discount@example.com',
            'customer_phone' => '611111119',
            'pickup_date' => now()->addDay()->toDateString(),
            'discount_code' => 'SAVE10',
            'discount_amount' => 10,
            'total' => 20,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('SAVE10 · -10,00 €', false);
        $response->assertSee('data-discount-code="SAVE10"', false);
        $response->assertSee('data-discount-amount="10,00"', false);
        $response->assertSee('Descuento', false);
    }

    public function test_admin_dashboard_displays_bite_party_labels_for_legacy_and_new_sizes(): void
    {
        $admin = User::factory()->create();

        $cake = Cake::create([
            'name' => 'Size Label Cake',
            'description' => 'Sizes',
            'price' => 22,
            'is_available' => true,
        ]);

        Order::create([
            'cake_id' => $cake->id,
            'items' => [
                [
                    'cake_id' => $cake->id,
                    'cake_name' => $cake->name,
                    'size' => 'S',
                    'quantity' => 1,
                    'unit_price' => 22,
                    'line_total' => 22,
                ],
                [
                    'cake_id' => $cake->id,
                    'cake_name' => $cake->name,
                    'size' => 'PARTY',
                    'quantity' => 1,
                    'unit_price' => 30,
                    'line_total' => 30,
                ],
            ],
            'customer_name' => 'Cliente Labels',
            'customer_email' => 'labels@example.com',
            'customer_phone' => '611111120',
            'pickup_date' => now()->addDay()->toDateString(),
            'total' => 52,
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('&quot;size&quot;:&quot;BITE&quot;', false);
        $response->assertSee('&quot;size&quot;:&quot;PARTY&quot;', false);
    }

    public function test_admin_can_create_and_delete_blocked_days(): void
    {
        $admin = User::factory()->create();
        $date = now()->addDays(2)->toDateString();

        $createResponse = $this->actingAs($admin)->post(route('admin.blocked-days.store'), [
            'date' => $date,
        ]);

        $createResponse->assertRedirect();
        $this->assertTrue(BlockedDay::query()->whereDate('date', $date)->exists());

        $blockedDay = BlockedDay::query()->firstOrFail();

        $deleteResponse = $this->actingAs($admin)->delete(route('admin.blocked-days.destroy', $blockedDay));

        $deleteResponse->assertRedirect();
        $this->assertDatabaseMissing('blocked_days', ['id' => $blockedDay->id]);
    }

    public function test_admin_cannot_block_today(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('admin.agenda.index'))
            ->post(route('admin.blocked-days.store'), [
                'date' => now()->toDateString(),
            ]);

        $response->assertRedirect(route('admin.agenda.index'));
        $response->assertSessionHasErrors('date');
        $this->assertDatabaseCount('blocked_days', 0);
    }

    public function test_admin_can_update_blocked_weekdays_from_agenda(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->put(route('admin.blocked-weekdays.update'), [
                'weekdays' => [1, 5, 7],
            ]);

        $response->assertRedirect(route('admin.agenda.index'));
        $this->assertDatabaseHas('blocked_weekdays', ['weekday' => 1]);
        $this->assertDatabaseHas('blocked_weekdays', ['weekday' => 5]);
        $this->assertDatabaseHas('blocked_weekdays', ['weekday' => 7]);
        $this->assertDatabaseCount('blocked_weekdays', 3);
    }

    public function test_admin_can_access_agenda_and_see_weekday_checkboxes(): void
    {
        $admin = User::factory()->create();
        BlockedWeekday::create(['weekday' => 1]);

        $response = $this->actingAs($admin)->get(route('admin.agenda.index'));

        $response->assertOk();
        $response->assertSee('Agenda de Pedidos');
        $response->assertSee('name="weekdays[]"', false);
        $response->assertSee('value="1"', false);
        $response->assertSee('checked', false);
    }

    public function test_admin_can_update_agenda_lead_time_rules(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->put(route('admin.agenda.lead-time.update'), [
                'cutoff_time' => '09:30',
                'min_days_before_cutoff' => 1,
                'min_days_after_cutoff' => 3,
            ]);

        $response->assertRedirect(route('admin.agenda.index'));
        $this->assertDatabaseHas('agenda_settings', [
            'cutoff_time' => '09:30',
            'min_days_before_cutoff' => 1,
            'min_days_after_cutoff' => 3,
        ]);

        $agendaResponse = $this->actingAs($admin)->get(route('admin.agenda.index'));
        $agendaResponse->assertOk();
        $agendaResponse->assertSee('name="cutoff_time"', false);
        $agendaResponse->assertSee('value="09:30"', false);
    }

    public function test_deprecated_blocked_days_index_redirects_to_agenda(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.blocked-days.index'))
            ->assertRedirect(route('admin.agenda.index'));
    }
}

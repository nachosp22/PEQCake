<?php

namespace Tests\Feature;

use App\Models\Discount;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDiscountCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_discounts_admin(): void
    {
        $adminLoginPath = '/'.trim((string) config('peq.admin_path'), '/').'/login';

        $this->get(route('admin.discounts.index'))->assertRedirect($adminLoginPath);
    }

    public function test_admin_can_create_update_toggle_and_delete_discount(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.discounts.store'), [
                'name' => 'Welcome 10',
                'discount_type' => 'code',
                'code' => 'WELCOME10',
                'value_type' => 'percentage',
                'value' => 10,
                'min_order_amount' => 25,
                'max_uses' => 100,
                'times_used' => 0,
                'is_active' => 1,
            ])
            ->assertRedirect();

        $discount = Discount::query()->firstOrFail();
        $this->assertSame('WELCOME10', $discount->code);
        $this->assertSame(25.0, (float) $discount->min_subtotal);

        $this->actingAs($admin)
            ->put(route('admin.discounts.update', $discount), [
                'name' => 'Auto 7',
                'discount_type' => 'automatic',
                'code' => null,
                'value_type' => 'fixed',
                'value' => 7,
                'min_order_amount' => 30,
                'max_uses' => 50,
                'times_used' => 3,
                'is_active' => 1,
            ])
            ->assertRedirect();

        $discount->refresh();
        $this->assertTrue((bool) $discount->is_automatic);
        $this->assertNull($discount->code);
        $this->assertSame('fixed', $discount->value_type);
        $this->assertSame(7.0, (float) $discount->value);
        $this->assertSame(30.0, (float) $discount->min_subtotal);

        $this->actingAs($admin)
            ->patch(route('admin.discounts.toggle-active', $discount))
            ->assertRedirect();

        $this->assertDatabaseHas('discounts', [
            'id' => $discount->id,
            'is_active' => false,
        ]);

        $this->actingAs($admin)
            ->delete(route('admin.discounts.destroy', $discount))
            ->assertRedirect();

        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);
    }

    public function test_code_discount_requires_code_and_valid_date_range(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('admin.discounts.index'))
            ->post(route('admin.discounts.store'), [
                'name' => 'Promo invalida',
                'discount_type' => 'code',
                'code' => '',
                'value_type' => 'fixed',
                'value' => 15,
                'starts_at' => '2026-04-15 10:00:00',
                'ends_at' => '2026-04-14 10:00:00',
                'is_active' => 1,
            ]);

        $response->assertRedirect(route('admin.discounts.index'));
        $response->assertSessionHasErrors(['code', 'ends_at']);

        $this->assertDatabaseCount('discounts', 0);
    }
}

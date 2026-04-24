<?php

namespace Tests\Feature;

use App\Models\Cake;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCakeCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_cakes_admin(): void
    {
        $adminLoginPath = '/'.trim((string) config('peq.admin_path'), '/').'/login';

        $this->get(route('admin.cakes.index'))->assertRedirect($adminLoginPath);
    }

    public function test_admin_can_view_cakes_admin_index(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.cakes.index'))
            ->assertOk()
            ->assertSee('Listado de tartas');
    }

    public function test_admin_can_create_update_soft_delete_and_restore_cake(): void
    {
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->post(route('admin.cakes.store'), [
                'name' => 'Lotus Supreme',
                'description' => 'Galleta lotus crujiente',
                'image_url' => 'https://example.com/cake.jpg',
                'price_s' => 24.50,
                'price_l' => 32.00,
                'is_available' => 1,
                'sort_order' => 7,
                'allergen_gluten' => 1,
                'allergen_milk' => 1,
            ])
            ->assertRedirect();

        $cake = Cake::query()->firstOrFail();
        $this->assertSame('Lotus Supreme', $cake->name);
        $this->assertSame(24.5, (float) $cake->price_s);
        $this->assertSame(32.0, (float) $cake->price_l);
        $this->assertSame(7, $cake->sort_order);
        $this->assertTrue((bool) $cake->allergen_gluten);
        $this->assertTrue((bool) $cake->allergen_milk);
        $this->assertFalse((bool) $cake->allergen_soy);

        $this->actingAs($admin)
            ->put(route('admin.cakes.update', $cake), [
                'name' => 'Lotus Supreme 2',
                'description' => 'Receta actualizada',
                'image_url' => 'https://example.com/cake-v2.jpg',
                'price_s' => 25.00,
                'price_l' => 35.00,
                'is_available' => 0,
                'sort_order' => 3,
                'allergen_soy' => 1,
                'allergen_sulfites' => 1,
            ])
            ->assertRedirect();

        $cake->refresh();
        $this->assertSame('Lotus Supreme 2', $cake->name);
        $this->assertFalse((bool) $cake->is_available);
        $this->assertSame(3, $cake->sort_order);
        $this->assertTrue((bool) $cake->allergen_soy);
        $this->assertTrue((bool) $cake->allergen_sulfites);
        $this->assertFalse((bool) $cake->allergen_gluten);
        $this->assertFalse((bool) $cake->allergen_milk);

        $this->actingAs($admin)
            ->delete(route('admin.cakes.destroy', $cake))
            ->assertRedirect();

        $this->assertSoftDeleted('cakes', ['id' => $cake->id]);

        $this->actingAs($admin)
            ->patch(route('admin.cakes.restore', $cake->id))
            ->assertRedirect();

        $this->assertDatabaseHas('cakes', [
            'id' => $cake->id,
            'deleted_at' => null,
        ]);
    }

    public function test_admin_cannot_create_cake_without_required_fields(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)
            ->from(route('admin.cakes.index'))
            ->post(route('admin.cakes.store'), [
                'description' => 'Sin nombre',
                'price_l' => 22,
            ]);

        $response->assertRedirect(route('admin.cakes.index'));
        $response->assertSessionHasErrors(['name', 'price_s']);

        $this->assertDatabaseCount('cakes', 0);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Cake;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    private function createTestCake(): Cake
    {
        return Cake::create([
            'name' => 'Test Cheesecake',
            'description' => 'Creamy test cheesecake',
            'price' => 25.00,
            'is_available' => true,
        ]);
    }

    public function test_member_can_be_identified_by_email(): void
    {
        $member = Member::factory()->create([
            'email' => 'test@example.com',
            'phone' => null,
            'password' => 'password123',
        ]);

        $response = $this->post('/socio/login', [
            'identifier' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertCookie('member_token');

        $token = $response->getCookie('member_token')?->getValue();
        $this->assertNotNull($token);

        $member->refresh();
        $this->assertEquals($token, $member->login_token);
    }

    public function test_member_can_be_identified_by_phone(): void
    {
        $member = Member::factory()->create([
            'phone' => '666123456',
            'email' => null,
            'password' => 'password123',
        ]);

        $response = $this->post('/socio/login', [
            'identifier' => '666123456',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('store.home'));
        $response->assertCookie('member_token');
    }

    public function test_member_login_fails_if_member_is_not_found(): void
    {
        $this->assertEquals(0, Member::count());

        $response = $this->post('/socio/login', [
            'identifier' => 'nuevomail@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/socio/login');
        $response->assertSessionHasErrors('identifier');
        $this->assertEquals(0, Member::count());
    }

    public function test_identifier_validation_required(): void
    {
        $response = $this->post('/socio/login', [
            'identifier' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('identifier');
        $response->assertSessionHasErrors('password');
    }

    public function test_member_logout_clears_token(): void
    {
        $member = Member::factory()->create([
            'login_token' => 'old-token',
            'token_expires_at' => now()->addYear(),
        ]);

        // Directly test the clearToken method
        $member->clearToken();

        $member->refresh();
        $this->assertNull($member->login_token);
        $this->assertNull($member->token_expires_at);
    }

    public function test_welcome_detects_logged_member_with_cookie(): void
    {
        $member = Member::factory()->create([
            'name' => 'Socio Test',
            'email' => 'socio@example.com',
            'phone' => '666111222',
            'password' => 'password123',
        ]);

        $loginResponse = $this->post('/socio/login', [
            'identifier' => 'socio@example.com',
            'password' => 'password123',
        ]);

        $loginResponse->assertRedirect(route('store.home'));

        $member->refresh();
        $this->assertNotNull($member->login_token);

        $response = $this
            ->withCookie('member_token', (string) $member->login_token)
            ->get(route('store.home'));

        $response->assertOk();
        $response->assertSeeText($member->formattedMemberNumber);
        $response->assertSeeText($member->name);
        $response->assertSeeText('Ver tarjeta');
        $response->assertDontSeeText('Identifícate →');
        $response->assertSee('name="customer_name" value="Socio Test" readonly', false);
        $response->assertSee('name="customer_email" value="socio@example.com" readonly', false);
        $response->assertSee('name="customer_phone" value="666111222" readonly', false);
    }

    public function test_order_increment_updates_level(): void
    {
        $member = Member::factory()->create([
            'total_orders' => 3,
            'current_level' => 3,
        ]);

        $member->incrementOrder();

        $this->assertEquals(4, $member->total_orders);
        $this->assertEquals(4, $member->current_level);
    }

    public function test_order_increment_sets_level_to_10_on_tenth_order(): void
    {
        $member = Member::factory()->create([
            'total_orders' => 9,
            'current_level' => 9,
        ]);

        $member->incrementOrder();

        $this->assertEquals(10, $member->total_orders);
        $this->assertEquals(10, $member->current_level);
    }

    public function test_order_without_member_works_normally(): void
    {
        $cake = $this->createTestCake();

        $response = $this->post('/order', $this->validOrderData($cake->id));

        $response->assertRedirect(route('store.home'));
        $this->assertEquals(0, Member::count());
    }

    private function validOrderData(int $cakeId): array
    {
        return [
            'customer_name' => 'Test Customer',
            'customer_email' => 'customer@test.com',
            'customer_phone' => '666123456',
            'delivery_date' => now()->addDays(2)->format('Y-m-d'),
            'pedido' => [
                [
                    'cake_id' => $cakeId,
                    'size' => 'BITE',
                    'quantity' => 1,
                ],
            ],
        ];
    }
}

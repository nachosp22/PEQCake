<?php

namespace Tests\Feature;

use App\Models\Cake;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        Cake::create([
            'name' => 'Test Cake',
            'description' => 'Test description',
            'price' => 10.00,
            'is_available' => true,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

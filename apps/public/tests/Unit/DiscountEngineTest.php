<?php

namespace Tests\Unit;

use App\Models\Discount;
use App\Services\DiscountEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DiscountEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_picks_best_between_code_and_automatic_discount(): void
    {
        Discount::create([
            'name' => 'Code 10%',
            'code' => 'SAVE10',
            'is_automatic' => false,
            'value_type' => 'percentage',
            'value' => 10,
            'is_active' => true,
        ]);

        Discount::create([
            'name' => 'Auto fixed 20',
            'code' => null,
            'is_automatic' => true,
            'value_type' => 'fixed',
            'value' => 20,
            'is_active' => true,
        ]);

        $engine = new DiscountEngine();

        $resolution = $engine->resolveBestDiscount('SAVE10', 150.0);

        $this->assertNotNull($resolution);
        $this->assertSame('Auto fixed 20', $resolution->discount->name);
        $this->assertSame(20.0, $resolution->amount);
    }

    public function test_it_prefers_code_discount_on_tie(): void
    {
        Discount::create([
            'name' => 'Code fixed 15',
            'code' => 'SAVE15',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 15,
            'is_active' => true,
        ]);

        Discount::create([
            'name' => 'Auto fixed 15',
            'code' => null,
            'is_automatic' => true,
            'value_type' => 'fixed',
            'value' => 15,
            'is_active' => true,
        ]);

        $engine = new DiscountEngine();
        $resolution = $engine->resolveBestDiscount('SAVE15', 100.0);

        $this->assertNotNull($resolution);
        $this->assertSame('Code fixed 15', $resolution->discount->name);
        $this->assertSame(15.0, $resolution->amount);
    }
}

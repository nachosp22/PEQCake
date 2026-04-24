<?php

namespace Tests\Unit;

use App\Models\Discount;
use App\Services\DiscountConsumptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DiscountConsumptionServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_hard_deletes_single_use_discount_on_consume(): void
    {
        $discount = Discount::create([
            'name' => 'One shot',
            'code' => 'ONCE',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 10,
            'max_uses' => 1,
            'times_used' => 0,
            'is_active' => true,
        ]);

        $service = new DiscountConsumptionService(DB::connection());

        $deleted = $service->consumeSingleUseDiscount($discount);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('discounts', ['id' => $discount->id]);
    }

    public function test_it_does_not_delete_non_single_use_discount(): void
    {
        $discount = Discount::create([
            'name' => 'Reusable',
            'code' => 'MANY',
            'is_automatic' => false,
            'value_type' => 'fixed',
            'value' => 10,
            'max_uses' => 3,
            'times_used' => 0,
            'is_active' => true,
        ]);

        $service = new DiscountConsumptionService(DB::connection());
        $deleted = $service->consumeSingleUseDiscount($discount);

        $this->assertFalse($deleted);
        $this->assertDatabaseHas('discounts', ['id' => $discount->id]);
    }
}

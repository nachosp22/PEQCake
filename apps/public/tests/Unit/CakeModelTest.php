<?php

namespace Tests\Unit;

use App\Models\Cake;
use Tests\TestCase;

class CakeModelTest extends TestCase
{
    public function test_price_for_size_uses_size_specific_prices(): void
    {
        $cake = new Cake([
            'price' => 10,
            'price_s' => 12,
            'price_l' => 18.5,
        ]);

        $this->assertSame(12.0, $cake->priceForSize('BITE'));
        $this->assertSame(18.5, $cake->priceForSize('PARTY'));
        $this->assertSame(18.5, $cake->priceForSize('l'));
    }

    public function test_price_for_size_falls_back_to_base_price_when_specific_missing(): void
    {
        $cake = new Cake([
            'price' => 15.25,
            'price_s' => 0,
            'price_l' => 0,
        ]);

        $this->assertSame(15.25, $cake->priceForSize('BITE'));
        $this->assertSame(15.25, $cake->priceForSize('PARTY'));
        $this->assertSame(15.25, $cake->priceForSize('invalid'));
    }

    public function test_normalize_size_maps_legacy_aliases_to_canonical_values(): void
    {
        $this->assertSame(Cake::SIZE_BITE, Cake::normalizeSize('S'));
        $this->assertSame(Cake::SIZE_BITE, Cake::normalizeSize('bite'));
        $this->assertSame(Cake::SIZE_PARTY, Cake::normalizeSize('L'));
        $this->assertSame(Cake::SIZE_PARTY, Cake::normalizeSize('party'));
        $this->assertSame(Cake::SIZE_BITE, Cake::normalizeSize('unknown'));
    }
}

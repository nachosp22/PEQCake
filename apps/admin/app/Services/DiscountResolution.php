<?php

namespace App\Services;

use App\Models\Discount;

class DiscountResolution
{
    public function __construct(
        public readonly Discount $discount,
        public readonly float $amount,
    ) {
    }

    public function discountCode(): ?string
    {
        return $this->discount->code;
    }
}

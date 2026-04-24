<?php

namespace App\Services;

use App\Models\Discount;
use Illuminate\Database\ConnectionInterface;

class DiscountConsumptionService
{
    public function __construct(
        private readonly ConnectionInterface $db,
    ) {
    }

    public function consumeSingleUseDiscount(Discount $discount): bool
    {
        return $this->db->transaction(fn (): bool => $this->consumeSingleUseDiscountUnsafe($discount));
    }

    public function consumeSingleUseDiscountById(int $discountId): bool
    {
        return $this->db->transaction(function () use ($discountId): bool {
            /** @var Discount|null $locked */
            $locked = Discount::query()
                ->whereKey($discountId)
                ->lockForUpdate()
                ->first();

            if (! $locked) {
                return false;
            }

            return $this->consumeSingleUseDiscountUnsafe($locked);
        });
    }

    private function consumeSingleUseDiscountUnsafe(Discount $discount): bool
    {
        if (! $discount->isSingleUseConsumable()) {
            return false;
        }

        if (! $discount->exists) {
            return false;
        }

        return (bool) $this->db->table($discount->getTable())
            ->where('id', $discount->id)
            ->delete();
    }
}

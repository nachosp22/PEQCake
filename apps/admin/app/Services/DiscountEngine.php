<?php

namespace App\Services;

use App\Models\Discount;
use Carbon\CarbonInterface;
use Illuminate\Support\Str;

class DiscountEngine
{
    public function resolveBestDiscount(?string $code, float $subtotal, ?CarbonInterface $now = null): ?DiscountResolution
    {
        $now ??= now();

        $codeDiscount = $this->evaluateExplicitCodeDiscount($code, $subtotal, $now);
        $automaticDiscount = $this->evaluateBestAutomaticDiscount($subtotal, $now);

        return $this->chooseBestSingleDiscount($codeDiscount, $automaticDiscount);
    }

    public function evaluateExplicitCodeDiscount(?string $code, float $subtotal, ?CarbonInterface $now = null): ?DiscountResolution
    {
        $normalizedCode = $this->normalizeCode($code);
        if ($normalizedCode === null) {
            return null;
        }

        $now ??= now();

        $discount = Discount::query()
            ->active()
            ->codeBased()
            ->currentlyValid($now)
            ->whereRaw('LOWER(code) = ?', [Str::lower($normalizedCode)])
            ->first();

        if (! $discount || ! $discount->isApplicable($subtotal, $now)) {
            return null;
        }

        $amount = $discount->calculateDiscountAmount($subtotal);

        return $amount > 0 ? new DiscountResolution($discount, $amount) : null;
    }

    /**
     * @return array{success:bool,status:string,message:string,resolution:?DiscountResolution}
     */
    public function previewExplicitCodeDiscount(?string $code, float $subtotal, ?CarbonInterface $now = null): array
    {
        $normalizedCode = $this->normalizeCode($code);
        if ($normalizedCode === null) {
            return [
                'success' => false,
                'status' => 'invalid',
                'message' => 'Introduce un código de descuento válido.',
                'resolution' => null,
            ];
        }

        $now ??= now();

        /** @var Discount|null $discount */
        $discount = Discount::query()
            ->codeBased()
            ->whereRaw('LOWER(code) = ?', [Str::lower($normalizedCode)])
            ->first();

        if (! $discount) {
            return [
                'success' => false,
                'status' => 'invalid',
                'message' => 'Código no válido.',
                'resolution' => null,
            ];
        }

        if (! $discount->is_active) {
            return [
                'success' => false,
                'status' => 'invalid',
                'message' => 'Este código no está activo.',
                'resolution' => null,
            ];
        }

        if ($discount->starts_at && $discount->starts_at->gt($now)) {
            return [
                'success' => false,
                'status' => 'invalid',
                'message' => 'Este código todavía no está disponible.',
                'resolution' => null,
            ];
        }

        if ($discount->ends_at && $discount->ends_at->lt($now)) {
            return [
                'success' => false,
                'status' => 'expired',
                'message' => 'Este código ha caducado.',
                'resolution' => null,
            ];
        }

        if (! $discount->hasRemainingUses()) {
            return [
                'success' => false,
                'status' => 'consumed',
                'message' => 'Este código ya fue consumido.',
                'resolution' => null,
            ];
        }

        $minimumSubtotal = (float) ($discount->min_subtotal ?? 0);
        if ($minimumSubtotal > 0 && $subtotal < $minimumSubtotal) {
            return [
                'success' => false,
                'status' => 'min_subtotal_not_met',
                'message' => sprintf('Este código requiere un subtotal mínimo de €%.2f.', $minimumSubtotal),
                'resolution' => null,
            ];
        }

        $amount = $discount->calculateDiscountAmount($subtotal);
        if ($amount <= 0) {
            return [
                'success' => false,
                'status' => 'invalid',
                'message' => 'No se pudo aplicar el descuento con el ticket actual.',
                'resolution' => null,
            ];
        }

        return [
            'success' => true,
            'status' => 'applied',
            'message' => 'Código aplicado correctamente.',
            'resolution' => new DiscountResolution($discount, $amount),
        ];
    }

    public function evaluateBestAutomaticDiscount(float $subtotal, ?CarbonInterface $now = null): ?DiscountResolution
    {
        $now ??= now();

        /** @var \Illuminate\Database\Eloquent\Collection<int, Discount> $discounts */
        $discounts = Discount::query()
            ->active()
            ->automatic()
            ->currentlyValid($now)
            ->get();

        $best = null;

        foreach ($discounts as $discount) {
            if (! $discount->isApplicable($subtotal, $now)) {
                continue;
            }

            $amount = $discount->calculateDiscountAmount($subtotal);
            if ($amount <= 0) {
                continue;
            }

            if ($best === null || $amount > $best->amount) {
                $best = new DiscountResolution($discount, $amount);
            }
        }

        return $best;
    }

    public function chooseBestSingleDiscount(?DiscountResolution $codeDiscount, ?DiscountResolution $automaticDiscount): ?DiscountResolution
    {
        if ($codeDiscount === null) {
            return $automaticDiscount;
        }

        if ($automaticDiscount === null) {
            return $codeDiscount;
        }

        return $codeDiscount->amount >= $automaticDiscount->amount
            ? $codeDiscount
            : $automaticDiscount;
    }

    public function isSingleUseConsumable(Discount $discount): bool
    {
        return $discount->isSingleUseConsumable();
    }

    private function normalizeCode(?string $code): ?string
    {
        if ($code === null) {
            return null;
        }

        $trimmed = trim($code);

        return $trimmed === '' ? null : $trimmed;
    }
}

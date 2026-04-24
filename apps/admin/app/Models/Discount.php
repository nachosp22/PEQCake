<?php

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'is_automatic',
        'value_type',
        'value',
        'min_subtotal',
        'starts_at',
        'ends_at',
        'max_uses',
        'times_used',
        'is_active',
    ];

    protected $casts = [
        'is_automatic' => 'boolean',
        'value' => 'decimal:2',
        'min_subtotal' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'max_uses' => 'integer',
        'times_used' => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeAutomatic(Builder $query): Builder
    {
        return $query->where('is_automatic', true);
    }

    public function scopeCodeBased(Builder $query): Builder
    {
        return $query->where('is_automatic', false)
            ->whereNotNull('code');
    }

    public function scopeCurrentlyValid(Builder $query, ?CarbonInterface $now = null): Builder
    {
        $now ??= now();

        return $query
            ->where(function (Builder $subQuery) use ($now): void {
                $subQuery->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
            })
            ->where(function (Builder $subQuery) use ($now): void {
                $subQuery->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            });
    }

    public function isApplicable(float $subtotal, ?CarbonInterface $now = null): bool
    {
        return $this->is_active
            && $this->isCurrentlyValid($now)
            && $this->hasRemainingUses()
            && $subtotal >= (float) ($this->min_subtotal ?? 0);
    }

    public function hasRemainingUses(): bool
    {
        if ($this->max_uses === null) {
            return true;
        }

        return (int) $this->times_used < (int) $this->max_uses;
    }

    public function isCurrentlyValid(?CarbonInterface $now = null): bool
    {
        $now ??= now();

        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }

        if ($this->ends_at && $this->ends_at->lt($now)) {
            return false;
        }

        return true;
    }

    public function matchesCode(?string $code): bool
    {
        if ($code === null || $this->code === null) {
            return false;
        }

        return strcasecmp(trim($this->code), trim($code)) === 0;
    }

    public function calculateDiscountAmount(float $subtotal): float
    {
        if ($subtotal <= 0) {
            return 0.0;
        }

        $amount = $this->value_type === 'percentage'
            ? $subtotal * ((float) $this->value / 100)
            : (float) $this->value;

        return round(min(max($amount, 0.0), $subtotal), 2);
    }

    public function isSingleUseConsumable(): bool
    {
        return (int) ($this->max_uses ?? 0) === 1;
    }
}

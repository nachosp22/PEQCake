<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cake_id',
        'member_id',
        'items',
        'customer_name',
        'customer_email',
        'customer_phone',
        'notes',
        'pickup_date',
        'total',
        'status',
        'discount_code',
        'discount_id',
        'discount_amount',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'items' => 'array',
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class);
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class)->withDefault();
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class)
            ->withDefault();
    }

    public function hasDiscountSnapshot(): bool
    {
        return ! empty($this->discount_code) && (float) $this->discount_amount > 0;
    }

    /**
     * @return array<int, array{cake_name:string,size:string,quantity:int,unit_price:float,line_total:float}>
     */
    public function normalizedItemsForAdmin(): array
    {
        $rawItems = $this->items;

        if (is_string($rawItems)) {
            $decoded = json_decode($rawItems, true);
            $rawItems = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($rawItems)) {
            $rawItems = [];
        }

        if ($rawItems !== [] && array_key_exists('cake_id', $rawItems)) {
            $rawItems = [$rawItems];
        }

        if (array_is_list($rawItems) === false) {
            $rawItems = array_values($rawItems);
        }

        $normalized = [];

        foreach ($rawItems as $item) {
            if (! is_array($item)) {
                continue;
            }

            $quantity = (int) ($item['quantity'] ?? $item['cantidad'] ?? 1);
            if ($quantity <= 0) {
                $quantity = 1;
            }

            $size = Cake::normalizeSize((string) ($item['size'] ?? $item['tamano'] ?? Cake::SIZE_BITE));

            $unitPrice = (float) ($item['unit_price'] ?? $item['price'] ?? 0);
            $lineTotal = $item['line_total'] ?? $item['total'] ?? null;
            $lineTotal = $lineTotal !== null ? (float) $lineTotal : round($unitPrice * $quantity, 2);

            $cakeName = (string) ($item['cake_name'] ?? $item['name'] ?? '');
            if ($cakeName === '' && isset($item['cake_id']) && (int) $item['cake_id'] === (int) $this->cake_id) {
                $cakeName = (string) ($this->cake?->name ?? 'Tarta');
            }

            $normalized[] = [
                'cake_name' => $cakeName !== '' ? $cakeName : 'Tarta',
                'size' => $size,
                'size_label' => $size,
                'quantity' => $quantity,
                'unit_price' => round($unitPrice, 2),
                'line_total' => round($lineTotal, 2),
            ];
        }

        if ($normalized === [] && $this->cake !== null) {
            $normalized[] = [
                'cake_name' => $this->cake->name,
                'size' => Cake::SIZE_BITE,
                'size_label' => Cake::SIZE_BITE,
                'quantity' => 1,
                'unit_price' => (float) ($this->total ?? $this->cake->price ?? 0),
                'line_total' => (float) ($this->total ?? $this->cake->price ?? 0),
            ];
        }

        return $normalized;
    }
}

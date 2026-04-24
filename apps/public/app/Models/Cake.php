<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cake extends Model
{
    use HasFactory, SoftDeletes;

    public const SIZE_BITE = 'BITE';

    public const SIZE_PARTY = 'PARTY';

    public const ALLERGEN_FIELDS = [
        'allergen_milk' => 'Leche',
        'allergen_eggs' => 'Huevos',
        'allergen_gluten' => 'Gluten',
        'allergen_nuts' => 'Frutos secos',
        'allergen_soy' => 'Soja',
        'allergen_sulfites' => 'Sulfitos',
    ];

    protected $fillable = [
        'name',
        'description',
        'price',
        'price_s',
        'price_l',
        'image_url',
        'is_available',
        'sort_order',
        'allergen_milk',
        'allergen_eggs',
        'allergen_gluten',
        'allergen_nuts',
        'allergen_soy',
        'allergen_sulfites',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_s' => 'decimal:2',
        'price_l' => 'decimal:2',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
        'allergen_milk' => 'boolean',
        'allergen_eggs' => 'boolean',
        'allergen_gluten' => 'boolean',
        'allergen_nuts' => 'boolean',
        'allergen_soy' => 'boolean',
        'allergen_sulfites' => 'boolean',
    ];

    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('is_available', true);
    }

    public function scopeSorted(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function priceForSize(string $size): float
    {
        $normalizedSize = self::normalizeSize($size);

        $selected = $normalizedSize === self::SIZE_PARTY
            ? ((float) ($this->price_l ?? 0) ?: (float) ($this->price ?? 0))
            : ((float) ($this->price_s ?? 0) ?: (float) ($this->price ?? 0));

        return round($selected, 2);
    }

    public static function normalizeSize(?string $size): string
    {
        $normalizedSize = strtoupper(trim((string) $size));

        return match ($normalizedSize) {
            'L', self::SIZE_PARTY => self::SIZE_PARTY,
            'S', self::SIZE_BITE => self::SIZE_BITE,
            default => self::SIZE_BITE,
        };
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return array<string, string>
     */
    public static function allergenOptions(): array
    {
        return self::ALLERGEN_FIELDS;
    }

    /**
     * @return array<int, array{field:string,label:string}>
     */
    public function activeAllergens(): array
    {
        return collect(self::ALLERGEN_FIELDS)
            ->filter(fn (string $label, string $field): bool => (bool) $this->{$field})
            ->map(fn (string $label, string $field): array => [
                'field' => $field,
                'label' => $label,
            ])
            ->values()
            ->all();
    }
}

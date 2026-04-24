<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array
    {
        $discountId = $this->route('discount')?->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'discount_type' => ['required', Rule::in(['code', 'automatic'])],
            'code' => [
                'nullable',
                'string',
                'max:64',
                'regex:/^[A-Za-z0-9_-]+$/',
                Rule::requiredIf(fn (): bool => $this->input('discount_type') === 'code'),
                Rule::unique('discounts', 'code')->ignore($discountId),
            ],
            'value_type' => ['required', Rule::in(['percentage', 'fixed'])],
            'value' => ['required', 'numeric', 'min:0.01', 'max:9999.99'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0', 'max:9999.99'],
            'max_uses' => ['nullable', 'integer', 'min:1', 'max:1000000'],
            'times_used' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $discountType = (string) $this->input('discount_type', 'code');

        $this->merge([
            'discount_type' => $discountType,
            'code' => $discountType === 'code' ? strtoupper(trim((string) $this->input('code', ''))) : null,
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}

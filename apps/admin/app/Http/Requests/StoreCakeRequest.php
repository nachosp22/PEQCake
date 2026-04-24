<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCakeRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image_url' => ['nullable', 'string', 'max:2048'],
            'price_s' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'price_l' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'is_available' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:9999'],
            'allergen_milk' => ['nullable', 'boolean'],
            'allergen_eggs' => ['nullable', 'boolean'],
            'allergen_gluten' => ['nullable', 'boolean'],
            'allergen_nuts' => ['nullable', 'boolean'],
            'allergen_soy' => ['nullable', 'boolean'],
            'allergen_sulfites' => ['nullable', 'boolean'],
        ];
    }
}

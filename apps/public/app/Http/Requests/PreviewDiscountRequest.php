<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PreviewDiscountRequest extends FormRequest
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
            'discount_code' => ['required', 'string', 'max:64', 'regex:/^[A-Za-z0-9_-]+$/'],
            'pedido' => ['required', 'array', 'min:1'],
            'pedido.*.cake_id' => [
                'required',
                Rule::exists('cakes', 'id')->where(fn ($query) => $query->where('is_available', true)),
            ],
            'pedido.*.size' => ['nullable', 'string', Rule::in(['BITE', 'PARTY', 'S', 'L'])],
            'pedido.*.quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $pedido = $this->input('pedido');

        if (! is_array($pedido)) {
            return;
        }

        $normalizedPedido = array_map(function ($item) {
            if (! is_array($item)) {
                return $item;
            }

            if (isset($item['size'])) {
                $item['size'] = strtoupper((string) $item['size']);
            }

            return $item;
        }, $pedido);

        $this->merge([
            'pedido' => $normalizedPedido,
        ]);
    }
}

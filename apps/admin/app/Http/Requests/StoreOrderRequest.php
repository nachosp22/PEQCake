<?php

namespace App\Http\Requests;

use App\Models\AgendaSetting;
use App\Models\BlockedDay;
use App\Models\BlockedWeekday;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
        $agendaSetting = AgendaSetting::current();
        $minimumPickupDate = $agendaSetting->minimumPickupDate();

        return [
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'delivery_date' => [
                'required',
                'date',
                'after:today',
                function (string $attribute, mixed $value, \Closure $fail) use ($minimumPickupDate): void {
                    if (! is_string($value)) {
                        return;
                    }

                    try {
                        $selectedDate = \Illuminate\Support\Carbon::parse($value)->startOfDay();
                    } catch (\Throwable) {
                        return;
                    }

                    if ($selectedDate->lt($minimumPickupDate->copy()->startOfDay())) {
                        $fail('La fecha seleccionada no cumple la antelacion minima configurada.');
                        return;
                    }

                    $isBlocked = BlockedDay::query()
                        ->whereDate('date', $value)
                        ->exists();

                    if ($isBlocked) {
                        $fail('La fecha seleccionada no esta disponible para pedidos.');
                        return;
                    }

                    try {
                        $weekday = (int) \Illuminate\Support\Carbon::parse($value)->dayOfWeekIso;
                    } catch (\Throwable) {
                        return;
                    }

                    $isBlockedWeekday = BlockedWeekday::query()
                        ->where('weekday', $weekday)
                        ->exists();

                    if ($isBlockedWeekday) {
                        $fail('La fecha seleccionada cae en un dia no disponible para pedidos.');
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:1000'],
            'discount_code' => ['nullable', 'string', 'max:64', 'regex:/^[A-Za-z0-9_-]+$/'],
            'cake_id' => [
                'nullable',
                Rule::exists('cakes', 'id')->where(fn ($query) => $query->where('is_available', true)),
            ],
            'pedido' => ['nullable', 'array', 'min:1'],
            'pedido.*.cake_id' => [
                'required_with:pedido',
                Rule::exists('cakes', 'id')->where(fn ($query) => $query->where('is_available', true)),
            ],
            'pedido.*.size' => ['nullable', 'string', Rule::in(['BITE', 'PARTY', 'S', 'L'])],
            'pedido.*.quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
            'pedido.*.tamano' => ['nullable', 'string', Rule::in(['BITE', 'PARTY', 'S', 'L'])],
            'pedido.*.cantidad' => ['nullable', 'integer', 'min:1', 'max:99'],
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

            if (isset($item['tamano'])) {
                $item['tamano'] = strtoupper((string) $item['tamano']);
            }

            return $item;
        }, $pedido);

        $this->merge([
            'pedido' => $normalizedPedido,
        ]);
    }
}

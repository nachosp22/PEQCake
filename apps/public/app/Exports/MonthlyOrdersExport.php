<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyOrdersExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    private CarbonImmutable $from;

    private CarbonImmutable $to;

    public function __construct(string $from, string $to)
    {
        $this->from = CarbonImmutable::parse($from)->startOfDay();
        $this->to = CarbonImmutable::parse($to)->endOfDay();
    }

    public function collection(): Collection
    {
        return Order::query()
            ->with('cake')
            ->whereDate('pickup_date', '>=', $this->from->toDateString())
            ->whereDate('pickup_date', '<=', $this->to->toDateString())
            ->orderBy('pickup_date')
            ->orderBy('id')
            ->get();
    }

    /**
     * @return array<int, string>
     */
    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Email',
            'Telefono',
            'Producto',
            'Cantidad total',
            'Fecha entrega',
            'Precio total',
            'Descuento',
            'Codigo descuento',
            'Estado',
            'Notas',
            'Creado en',
        ];
    }

    /**
     * @return array<int, int|float|string>
     */
    public function map($order): array
    {
        $items = $order->normalizedItemsForAdmin();

        $productSummary = collect($items)
            ->map(function (array $item): string {
                $quantity = (int) ($item['quantity'] ?? 0);
                $name = (string) ($item['cake_name'] ?? 'Tarta');
                $size = (string) ($item['size'] ?? 'BITE');

                return sprintf('%s (%s) x%d', $name, $size, $quantity);
            })
            ->implode(' | ');

        $totalQuantity = (int) collect($items)->sum('quantity');
        $discountAmount = (float) ($order->discount_amount ?? 0);

        return [
            $order->id,
            (string) $order->customer_name,
            (string) $order->customer_email,
            (string) ($order->customer_phone ?? ''),
            $productSummary !== '' ? $productSummary : ((string) ($order->cake?->name ?? 'Tarta')),
            $totalQuantity,
            $order->pickup_date?->format('Y-m-d') ?? '',
            (float) ($order->total ?? 0),
            $discountAmount,
            (string) ($order->discount_code ?? ''),
            (string) $order->status,
            (string) ($order->notes ?? ''),
            $order->created_at?->format('Y-m-d H:i:s') ?? '',
        ];
    }
}

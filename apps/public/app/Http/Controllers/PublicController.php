<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreviewDiscountRequest;
use App\Http\Requests\StoreOrderRequest;
use App\Mail\OrderConfirmation;
use App\Models\AgendaSetting;
use App\Models\Cake;
use App\Models\BlockedDay;
use App\Models\BlockedWeekday;
use App\Models\Discount;
use App\Models\Member;
use App\Models\Order;
use App\Services\DiscountConsumptionService;
use App\Services\DiscountEngine;
use App\Services\DiscountResolution;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class PublicController extends Controller
{
    private const SIZE_LABELS = [
        Cake::SIZE_BITE => 'BITE',
        Cake::SIZE_PARTY => 'PARTY',
    ];

    public function __construct(
        private readonly DiscountEngine $discountEngine,
        private readonly DiscountConsumptionService $discountConsumptionService,
    ) {
    }

    public function index(): View
    {
        $cakes = Cake::query()
            ->available()
            ->sorted()
            ->get();

        $heroVideo = [
            'enabled' => (bool) config('peq.public_hero_video_enabled', true),
            'mobile_autoplay' => (bool) config('peq.public_hero_video_mobile_autoplay', false),
        ];

        $blockedDates = BlockedDay::query()
            ->whereDate('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->pluck('date')
            ->map(fn ($date) => \Illuminate\Support\Carbon::parse($date)->toDateString())
            ->values();

        $blockedWeekdays = BlockedWeekday::query()
            ->orderBy('weekday')
            ->pluck('weekday')
            ->map(fn (mixed $weekday): int => (int) $weekday)
            ->values();

        $member = request()->attributes->get('member');

        $agendaSetting = AgendaSetting::current();
        $minimumPickupDate = $agendaSetting->minimumPickupDate()->toDateString();

        return view('welcome', compact('cakes', 'heroVideo', 'blockedDates', 'blockedWeekdays', 'member', 'agendaSetting', 'minimumPickupDate'));
    }

    public function storeOrder(StoreOrderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        /** @var Member|null $member */
        $member = $request->attributes->get('member');

        $normalizedItems = $this->normalizeItems($validated['pedido'] ?? []);

        if ($normalizedItems === []) {
            if (! empty($validated['cake_id'])) {
                $normalizedItems = [[
                    'cake_id' => (int) $validated['cake_id'],
                    'size' => Cake::SIZE_BITE,
                    'quantity' => 1,
                ]];
            } else {
                return redirect()->route('store.home')
                    ->withErrors(['pedido' => 'Debes añadir al menos una tarta al ticket.'])
                    ->withInput();
            }
        }

        $cakeIds = collect($normalizedItems)->pluck('cake_id')->unique()->values();

        /** @var Collection<int, Cake> $cakes */
        $cakes = Cake::query()
            ->whereIn('id', $cakeIds)
            ->available()
            ->get()
            ->keyBy('id');

        $resolvedItems = [];
        $total = 0.0;

        foreach ($normalizedItems as $item) {
            /** @var Cake|null $cake */
            $cake = $cakes->get($item['cake_id']);
            if (! $cake) {
                return redirect()->route('store.home')
                    ->withErrors(['pedido' => 'Una de las tartas seleccionadas ya no está disponible.'])
                    ->withInput();
            }

            $unitPrice = $cake->priceForSize($item['size']);
            $lineTotal = $unitPrice * $item['quantity'];
            $total += $lineTotal;

            $resolvedItems[] = [
                'cake_id' => (int) $cake->id,
                'cake_name' => $cake->name,
                'size' => $item['size'],
                'size_label' => self::SIZE_LABELS[$item['size']] ?? $item['size'],
                'quantity' => (int) $item['quantity'],
                'unit_price' => $unitPrice,
                'line_total' => round($lineTotal, 2),
            ];
        }

        $requestedCode = $validated['discount_code'] ?? null;
            $orderEmail = null;
            $previousLevel = $member?->current_level ?? 0;
            $levelJustReset = false;
            $totalAfterOrder = 0;

            DB::transaction(function () use ($validated, $resolvedItems, $total, $requestedCode, &$orderEmail, $member, &$previousLevel, &$levelJustReset, &$totalAfterOrder): void {
                $subtotal = round($total, 2);

                $codeResolution = $this->discountEngine->evaluateExplicitCodeDiscount($requestedCode, $subtotal);
                $lockedCodeResolution = $this->lockAndRevalidateCodeResolution($codeResolution, $subtotal);
                $automaticResolution = $this->discountEngine->evaluateBestAutomaticDiscount($subtotal);

                $appliedResolution = $this->discountEngine->chooseBestSingleDiscount(
                    $lockedCodeResolution,
                    $automaticResolution,
                );

                $discountAmount = round($appliedResolution?->amount ?? 0, 2);

                $order = Order::create([
                    'cake_id' => $resolvedItems[0]['cake_id'],
                    'items' => $resolvedItems,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'notes' => $validated['notes'] ?? null,
                    'pickup_date' => $validated['delivery_date'],
                    'total' => round(max($subtotal - $discountAmount, 0), 2),
                    'status' => 'pending',
                    'discount_code' => $appliedResolution?->discountCode(),
                    'discount_id' => $appliedResolution?->discount->id,
                    'discount_amount' => $discountAmount,
                ]);

                $orderEmail = $order;

                if (
                    $appliedResolution !== null
                    && $this->discountEngine->isSingleUseConsumable($appliedResolution->discount)
                ) {
                    $deleted = $this->discountConsumptionService->consumeSingleUseDiscountById($appliedResolution->discount->id);

                    if (! $deleted) {
                        throw new \RuntimeException('Failed to consume single-use discount within checkout transaction.');
                    }
                }

                if ($member) {
                    $previousLevel = $member->current_level;
                    $member->incrementOrder();
                    $totalAfterOrder = $member->total_orders;
                    $levelJustReset = $previousLevel === 9 && $member->current_level === 0;
                    $order->update(['member_id' => $member->id]);
                }
            });

        $successMessage = 'Estamos procesando tu pedido. En breves recibirás un correo confirmando el pedido y con los métodos de pago disponibles. Gracias por confiar en PEQCakes.';

        if ($member && $levelJustReset) {
            $successMessage .= ' Además, este pedido #' . $totalAfterOrder . ' completa tu ciclo PEQLOVER y reinicia tu nivel.';
        }

        return redirect()->route('store.home')
            ->with('success', $successMessage);
    }

    public function previewDiscount(PreviewDiscountRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $normalizedItems = $this->normalizeItems($validated['pedido'] ?? []);
        if ($normalizedItems === []) {
            return response()->json([
                'success' => false,
                'discount' => null,
                'subtotal' => 0.0,
                'discount_amount' => 0.0,
                'total' => 0.0,
                'message' => 'Añade al menos una tarta al ticket antes de aplicar el código.',
            ], 422);
        }

        [$resolvedItems, $subtotal, $errorMessage] = $this->resolveTicket($normalizedItems);

        if ($errorMessage !== null) {
            return response()->json([
                'success' => false,
                'discount' => null,
                'subtotal' => round($subtotal, 2),
                'discount_amount' => 0.0,
                'total' => round($subtotal, 2),
                'message' => $errorMessage,
            ], 422);
        }

        $preview = $this->discountEngine->previewExplicitCodeDiscount($validated['discount_code'] ?? null, $subtotal);

        if (! $preview['success']) {
            return response()->json([
                'success' => false,
                'discount' => null,
                'status' => $preview['status'],
                'subtotal' => round($subtotal, 2),
                'discount_amount' => 0.0,
                'total' => round($subtotal, 2),
                'message' => $preview['message'],
                'items_count' => count($resolvedItems),
            ]);
        }

        /** @var DiscountResolution $resolution */
        $resolution = $preview['resolution'];
        $discountAmount = round($resolution->amount, 2);

        return response()->json([
            'success' => true,
            'status' => 'applied',
            'discount' => [
                'id' => $resolution->discount->id,
                'name' => $resolution->discount->name,
                'code' => $resolution->discountCode(),
                'value_type' => $resolution->discount->value_type,
                'value' => (float) $resolution->discount->value,
            ],
            'subtotal' => round($subtotal, 2),
            'discount_amount' => $discountAmount,
            'total' => round(max($subtotal - $discountAmount, 0), 2),
            'message' => $preview['message'],
            'items_count' => count($resolvedItems),
        ]);
    }

    private function lockAndRevalidateCodeResolution(?DiscountResolution $resolution, float $subtotal): ?DiscountResolution
    {
        if ($resolution === null) {
            return null;
        }

        /** @var Discount|null $lockedDiscount */
        $lockedDiscount = Discount::query()
            ->whereKey($resolution->discount->id)
            ->lockForUpdate()
            ->first();

        if (! $lockedDiscount || ! $lockedDiscount->isApplicable($subtotal, now())) {
            return null;
        }

        $amount = $lockedDiscount->calculateDiscountAmount($subtotal);

        return $amount > 0
            ? new DiscountResolution($lockedDiscount, $amount)
            : null;
    }

    /**
     * @param  array<int, array{cake_id:int,size:string,quantity:int}>  $normalizedItems
     * @return array{0: array<int, array<string, mixed>>, 1: float, 2: string|null}
     */
    private function resolveTicket(array $normalizedItems): array
    {
        $cakeIds = collect($normalizedItems)->pluck('cake_id')->unique()->values();

        /** @var Collection<int, Cake> $cakes */
        $cakes = Cake::query()
            ->whereIn('id', $cakeIds)
            ->available()
            ->get()
            ->keyBy('id');

        $resolvedItems = [];
        $subtotal = 0.0;

        foreach ($normalizedItems as $item) {
            /** @var Cake|null $cake */
            $cake = $cakes->get($item['cake_id']);
            if (! $cake) {
                return [[], 0.0, 'Una de las tartas seleccionadas ya no está disponible.'];
            }

            $unitPrice = $cake->priceForSize($item['size']);
            $lineTotal = $unitPrice * $item['quantity'];
            $subtotal += $lineTotal;

            $resolvedItems[] = [
                'cake_id' => (int) $cake->id,
                'cake_name' => $cake->name,
                'size' => $item['size'],
                'size_label' => self::SIZE_LABELS[$item['size']] ?? $item['size'],
                'quantity' => (int) $item['quantity'],
                'unit_price' => $unitPrice,
                'line_total' => round($lineTotal, 2),
            ];
        }

        return [$resolvedItems, round($subtotal, 2), null];
    }

    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array{cake_id:int,size:string,quantity:int}>
     */
    private function normalizeItems(array $items): array
    {
        $normalized = [];

        foreach ($items as $item) {
            $cakeId = isset($item['cake_id']) ? (int) $item['cake_id'] : 0;
            $quantity = isset($item['quantity']) ? (int) $item['quantity'] : (int) ($item['cantidad'] ?? 1);
            $size = isset($item['size']) ? (string) $item['size'] : (string) ($item['tamano'] ?? Cake::SIZE_BITE);
            $size = Cake::normalizeSize($size);

            if ($cakeId <= 0 || $quantity <= 0) {
                continue;
            }

            $normalized[] = [
                'cake_id' => $cakeId,
                'size' => $size,
                'quantity' => min($quantity, 99),
            ];
        }

        return $normalized;
    }
}

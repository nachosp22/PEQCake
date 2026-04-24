<?php

namespace Tests\Unit;

use App\Models\Member;
use PHPUnit\Framework\TestCase;

class MemberModelTest extends TestCase
{
    public function test_level_calculation_formula(): void
    {
        // Fórmula: ((total_orders - 1) % 10) + 1, o 0 si total_orders <= 0
        $testCases = [
            ['total_orders' => 0, 'expected_level' => 0],   // Sin pedidos = gris
            ['total_orders' => 1, 'expected_level' => 1],
            ['total_orders' => 5, 'expected_level' => 5],
            ['total_orders' => 9, 'expected_level' => 9],
            ['total_orders' => 10, 'expected_level' => 10],  // 🏆 Premio máximo
            ['total_orders' => 11, 'expected_level' => 1],   // Reinicio a nivel 1
            ['total_orders' => 19, 'expected_level' => 9],
            ['total_orders' => 20, 'expected_level' => 10],  // 🏆 Premio máximo
            ['total_orders' => 99, 'expected_level' => 9],
            ['total_orders' => 100, 'expected_level' => 10], // 🏆 Premio máximo
        ];

        foreach ($testCases as $case) {
            $level = Member::calculateLevel($case['total_orders']);
            $this->assertEquals(
                $case['expected_level'],
                $level,
                "total_orders={$case['total_orders']} should give level {$case['expected_level']}, got {$level}"
            );
        }
    }

    public function test_level_resets_after_10_orders(): void
    {
        // Simular lógica de incrementOrder sin BD
        // Miembro con 9 pedidos debe estar en nivel 9
        $totalOrders = 9;
        $currentLevel = Member::calculateLevel($totalOrders);
        $this->assertEquals(9, $currentLevel);

        // Al hacer el pedido 10, sube a nivel 10 (premio máximo)
        $totalOrders++;
        $currentLevel = Member::calculateLevel($totalOrders);
        $this->assertEquals(10, $totalOrders);
        $this->assertEquals(10, $currentLevel);

        // Al hacer el pedido 11, reinicia a nivel 1
        $totalOrders++;
        $currentLevel = Member::calculateLevel($totalOrders);
        $this->assertEquals(11, $totalOrders);
        $this->assertEquals(1, $currentLevel);

        // Ciclar más: pedido 20 = nivel 10
        $totalOrders = 20;
        $currentLevel = Member::calculateLevel($totalOrders);
        $this->assertEquals(10, $currentLevel);
    }

    public function test_calculate_level_static_method(): void
    {
        $this->assertEquals(0, Member::calculateLevel(0));
        $this->assertEquals(1, Member::calculateLevel(1));
        $this->assertEquals(3, Member::calculateLevel(3));  // 🎁 Premio
        $this->assertEquals(5, Member::calculateLevel(5));  // 🎁 Premio
        $this->assertEquals(10, Member::calculateLevel(10)); // 🏆 Premio máximo
        $this->assertEquals(1, Member::calculateLevel(11));
        $this->assertEquals(10, Member::calculateLevel(20));
    }

    public function test_formatted_member_number(): void
    {
        $member = new Member(['member_number' => 1]);
        $this->assertEquals('#0001', $member->formatted_member_number);

        $member2 = new Member(['member_number' => 42]);
        $this->assertEquals('#0042', $member2->formatted_member_number);

        $member3 = new Member(['member_number' => 999]);
        $this->assertEquals('#0999', $member3->formatted_member_number);
    }
}

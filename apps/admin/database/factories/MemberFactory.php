<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    private static int $memberSequence = 0;

    public function definition(): array
    {
        self::$memberSequence++;

        return [
            'member_number' => 10000 + self::$memberSequence + Member::count(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'total_orders' => $this->faker->numberBetween(0, 50),
            'current_level' => fn (array $attrs) => ($attrs['total_orders'] ?? 0) % 10,
            'login_token' => null,
            'token_expires_at' => null,
        ];
    }

    public function withToken(): static
    {
        return $this->state(fn (array $attrs): array => [
            'login_token' => \Illuminate\Support\Str::uuid()->toString(),
            'token_expires_at' => now()->addYear(),
        ]);
    }

    public function newMember(): static
    {
        return $this->state(fn (array $attrs): array => [
            'total_orders' => 0,
            'current_level' => 0,
            'name' => null,
        ]);
    }

    public function withOrders(int $count): static
    {
        return $this->state(fn (array $attrs): array => [
            'total_orders' => $count,
            'current_level' => $count % 10,
        ]);
    }
}

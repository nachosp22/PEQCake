<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Member;
use Illuminate\Support\Str;

class MemberService
{
    public function __construct(
        private readonly Member $member,
    ) {}

    public function incrementOrder(): void
    {
        $this->member->total_orders++;
        // Niveles 0-10: 0 pedidos = nivel 0 (gris), 1-10 pedidos = niveles 1-10, 11+ ciclos a 1-9,10
        $this->member->current_level = (($this->member->total_orders - 1) % 10) + 1;
        $this->member->save();
    }

    public function regenerateToken(): string
    {
        $this->member->login_token = Str::uuid()->toString();
        $this->member->token_expires_at = now()->addYear();
        $this->member->save();

        return $this->member->login_token;
    }

    public function clearToken(): void
    {
        $this->member->login_token = null;
        $this->member->token_expires_at = null;
        $this->member->save();
    }

    public static function identifyOrCreate(string $identifier): Member
    {
        $member = Member::findByIdentifier($identifier);

        if ($member) {
            return $member;
        }

        $isEmail = filter_var($identifier, FILTER_VALIDATE_EMAIL) !== false;

        return Member::create([
            'member_number' => Member::max('member_number') + 1,
            'email' => $isEmail ? $identifier : null,
            'phone' => $isEmail ? null : $identifier,
            'total_orders' => 0,
            'current_level' => 0,
        ]);
    }

    public static function regenerateMemberToken(Member $member): string
    {
        $service = new self($member);
        return $service->regenerateToken();
    }
}

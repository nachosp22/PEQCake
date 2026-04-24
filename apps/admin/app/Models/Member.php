<?php

declare(strict_types=1);

namespace App\Models;

use App\Mail\MemberPasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_number',
        'name',
        'email',
        'phone',
        'password',
        'total_orders',
        'current_level',
        'login_token',
        'token_expires_at',
        'reset_token',
        'reset_sent_at',
    ];

    protected $casts = [
        'total_orders' => 'integer',
        'current_level' => 'integer',
        'token_expires_at' => 'datetime',
        'reset_sent_at' => 'datetime',
    ];

    protected $hidden = [
        'login_token',
        'password',
        'reset_token',
    ];

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function hasPassword(): bool
    {
        return ! empty($this->password);
    }

    public function sendPasswordResetNotification(int $expiresInMinutes = 60): void
    {
        $token = Str::random(64);
        
        $this->update([
            'reset_token' => $token,
            'reset_sent_at' => now(),
        ]);

        Mail::to($this->email)->send(new MemberPasswordReset($this, $token));
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function isTokenValid(): bool
    {
        return $this->login_token !== null
            && $this->token_expires_at !== null
            && $this->token_expires_at->isFuture();
    }

    public function regenerateToken(): string
    {
        $this->login_token = Str::uuid()->toString();
        $this->token_expires_at = now()->addYear();
        $this->save();

        return $this->login_token;
    }

    public function clearToken(): void
    {
        $this->login_token = null;
        $this->token_expires_at = null;
        $this->save();
    }

    public function incrementOrder(): void
    {
        $this->total_orders++;
        // Niveles 0-10: 0 pedidos = nivel 0 (gris), 1-10 pedidos = niveles 1-10, 11+ ciclos a 1-9,10
        $this->current_level = (($this->total_orders - 1) % 10) + 1;
        $this->save();
    }

    /**
     * Calcula el nivel basado en número de pedidos.
     * 0 pedidos → nivel 0 (gris, sin Pacman)
     * 1-9 pedidos → niveles 1-9
     * 10 pedidos → nivel 10 (🏆 premio máximo)
     * 11+ pedidos → ciclos: 11→1, 12→2, ... 20→10, 21→1...
     */
    public static function calculateLevel(int $totalOrders): int
    {
        if ($totalOrders <= 0) {
            return 0;
        }
        return (($totalOrders - 1) % 10) + 1;
    }

    public function scopeByIdentifier($query, string $identifier)
    {
        return $query->where(function ($q) use ($identifier) {
            $q->where('email', $identifier);
            if (preg_match('/^[0-9+\-\s]{6,20}$/', $identifier)) {
                $cleanPhone = preg_replace('/[^0-9+]/', '', $identifier);
                $q->orWhere('phone', 'LIKE', '%' . $cleanPhone);
            }
        });
    }

    public static function findByIdentifier(string $identifier): ?self
    {
        return static::where('email', $identifier)->first()
            ?? static::where('phone', $identifier)->first();
    }

    public static function identifyOrCreate(string $identifier): ?self
    {
        $member = static::findByIdentifier($identifier);

        if ($member) {
            return $member;
        }

        return null;
    }

    public function getFormattedMemberNumberAttribute(): string
    {
        return '#' . str_pad((string) $this->member_number, 4, '0', STR_PAD_LEFT);
    }

    public function getFormattedMemberNumberUnderscoreAttribute(): string
    {
        return $this->formattedMemberNumber;
    }
}

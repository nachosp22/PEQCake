<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AgendaSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'cutoff_time',
        'min_days_before_cutoff',
        'min_days_after_cutoff',
    ];

    protected $casts = [
        'min_days_before_cutoff' => 'integer',
        'min_days_after_cutoff' => 'integer',
    ];

    /**
     * @return array<string, int|string>
     */
    public static function defaultAttributes(): array
    {
        return [
            'cutoff_time' => (string) config('peq.agenda_cutoff_time', '10:00'),
            'min_days_before_cutoff' => max(1, (int) config('peq.agenda_min_days_before_cutoff', 1)),
            'min_days_after_cutoff' => max(1, (int) config('peq.agenda_min_days_after_cutoff', 2)),
        ];
    }

    public static function current(): self
    {
        $setting = static::query()->first();

        if ($setting !== null) {
            return $setting;
        }

        return new self(static::defaultAttributes());
    }

    public static function currentOrCreate(): self
    {
        return static::query()->firstOrCreate([], static::defaultAttributes());
    }

    public function minimumLeadDays(?Carbon $reference = null): int
    {
        $reference ??= now();
        $cutoffTime = $this->resolveCutoffTime();
        $cutoffMoment = $reference->copy()->setTimeFromTimeString($cutoffTime);

        if ($reference->lt($cutoffMoment)) {
            return max(1, (int) $this->min_days_before_cutoff);
        }

        return max(1, (int) $this->min_days_after_cutoff);
    }

    public function minimumPickupDate(?Carbon $reference = null): Carbon
    {
        $reference ??= now();

        return $reference->copy()->startOfDay()->addDays($this->minimumLeadDays($reference));
    }

    public function resolveCutoffTime(): string
    {
        $time = (string) $this->cutoff_time;

        if (preg_match('/^([01]\d|2[0-3]):([0-5]\d)(?::[0-5]\d)?$/', $time, $matches) === 1) {
            return $matches[1].':'.$matches[2];
        }

        return (string) static::defaultAttributes()['cutoff_time'];
    }
}

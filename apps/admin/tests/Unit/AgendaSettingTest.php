<?php

namespace Tests\Unit;

use App\Models\AgendaSetting;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class AgendaSettingTest extends TestCase
{
    public function test_minimum_pickup_date_uses_before_cutoff_days(): void
    {
        Carbon::setTestNow('2026-04-09 09:00:00');

        $setting = new AgendaSetting([
            'cutoff_time' => '10:00',
            'min_days_before_cutoff' => 1,
            'min_days_after_cutoff' => 2,
        ]);

        $this->assertSame(1, $setting->minimumLeadDays(now()));
        $this->assertSame('2026-04-10', $setting->minimumPickupDate(now())->toDateString());

        Carbon::setTestNow();
    }

    public function test_minimum_pickup_date_uses_after_cutoff_days(): void
    {
        Carbon::setTestNow('2026-04-09 10:00:00');

        $setting = new AgendaSetting([
            'cutoff_time' => '10:00',
            'min_days_before_cutoff' => 1,
            'min_days_after_cutoff' => 2,
        ]);

        $this->assertSame(2, $setting->minimumLeadDays(now()));
        $this->assertSame('2026-04-11', $setting->minimumPickupDate(now())->toDateString());

        Carbon::setTestNow();
    }

    public function test_resolve_cutoff_time_normalizes_seconds(): void
    {
        $setting = new AgendaSetting([
            'cutoff_time' => '09:30:00',
            'min_days_before_cutoff' => 1,
            'min_days_after_cutoff' => 2,
        ]);

        $this->assertSame('09:30', $setting->resolveCutoffTime());
    }
}

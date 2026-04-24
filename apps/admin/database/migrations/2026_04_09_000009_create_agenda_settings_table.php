<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agenda_settings', function (Blueprint $table): void {
            $table->id();
            $table->time('cutoff_time')->default('10:00:00');
            $table->unsignedTinyInteger('min_days_before_cutoff')->default(1);
            $table->unsignedTinyInteger('min_days_after_cutoff')->default(2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agenda_settings');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cakes', function (Blueprint $table): void {
            $table->decimal('price_s', 10, 2)->default(0)->after('price');
            $table->decimal('price_l', 10, 2)->default(0)->after('price_s');
            $table->unsignedInteger('sort_order')->default(0)->after('is_available');
            $table->softDeletes()->after('updated_at');
        });

        DB::table('cakes')->update([
            'price_s' => DB::raw('price'),
            'price_l' => DB::raw('price'),
        ]);
    }

    public function down(): void
    {
        Schema::table('cakes', function (Blueprint $table): void {
            $table->dropSoftDeletes();
            $table->dropColumn(['price_s', 'price_l', 'sort_order']);
        });
    }
};

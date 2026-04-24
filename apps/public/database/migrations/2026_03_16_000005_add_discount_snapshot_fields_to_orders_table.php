<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->text('notes')->nullable()->after('customer_phone');
            $table->string('discount_code')->nullable()->after('status');
            $table->foreignId('discount_id')
                ->nullable()
                ->after('discount_code')
                ->constrained('discounts')
                ->nullOnDelete();
            $table->decimal('discount_amount', 10, 2)->default(0)->after('discount_id');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('discount_id');
            $table->dropColumn(['notes', 'discount_code', 'discount_amount']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cakes', function (Blueprint $table): void {
            $table->boolean('allergen_milk')->default(false)->after('sort_order');
            $table->boolean('allergen_eggs')->default(false)->after('allergen_milk');
            $table->boolean('allergen_gluten')->default(false)->after('allergen_eggs');
            $table->boolean('allergen_nuts')->default(false)->after('allergen_gluten');
            $table->boolean('allergen_soy')->default(false)->after('allergen_nuts');
            $table->boolean('allergen_sulfites')->default(false)->after('allergen_soy');
        });
    }

    public function down(): void
    {
        Schema::table('cakes', function (Blueprint $table): void {
            $table->dropColumn([
                'allergen_milk',
                'allergen_eggs',
                'allergen_gluten',
                'allergen_nuts',
                'allergen_soy',
                'allergen_sulfites',
            ]);
        });
    }
};

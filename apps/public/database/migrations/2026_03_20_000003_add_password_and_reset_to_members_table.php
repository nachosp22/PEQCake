<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table): void {
            $table->string('password', 255)->nullable()->after('email');
            $table->string('reset_token', 255)->nullable()->after('password');
            $table->timestamp('reset_sent_at')->nullable()->after('reset_token');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table): void {
            $table->dropColumn(['password', 'reset_token', 'reset_sent_at']);
        });
    }
};
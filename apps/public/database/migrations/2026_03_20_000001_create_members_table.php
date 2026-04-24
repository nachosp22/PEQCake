<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('member_number')->unique();
            $table->string('name', 255)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('phone', 32)->unique()->nullable();
            $table->unsignedInteger('total_orders')->default(0);
            $table->unsignedTinyInteger('current_level')->default(0);
            $table->string('login_token', 64)->nullable()->index();
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();

            $table->index(['email', 'phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};

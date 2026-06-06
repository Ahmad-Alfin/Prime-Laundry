<?php
// database/migrations/2026_01_01_000001_create_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->string('password')->nullable();
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('zip', 10)->nullable();
            $table->boolean('is_admin')->default(false);
            $table->string('membership', 50)->nullable();
            $table->date('member_since')->nullable();
            $table->date('member_expiry')->nullable();
            $table->string('social_provider', 30)->nullable();
            $table->string('social_id', 200)->nullable();
            $table->text('avatar')->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

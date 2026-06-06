<?php
// database/migrations/2026_01_01_000002_create_orders_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer', 100);
            $table->string('phone', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('service', 80);
            $table->json('items')->nullable();
            $table->integer('total')->default(0);
            $table->date('pickup_date')->nullable();
            $table->time('pickup_time')->nullable();
            $table->string('status', 50)->default('still in process');
            $table->string('payment_status', 20)->default('unpaid');
            $table->timestamp('paid_at')->nullable();
            $table->date('date')->default(now());
            $table->timestamps();
        });

        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->string('email', 150);
            $table->text('pesan');
            $table->timestamps();
        });

        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->date('lahir')->nullable();
            $table->text('alamat')->nullable();
            $table->string('kota', 100)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('whatsapp', 20);
            $table->string('membership', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('memberships');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('orders');
    }
};

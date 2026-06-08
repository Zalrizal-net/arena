<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('seller_wallets', function (Blueprint $table) {
            $table->id();
            // Asumsi seller adalah user dengan role tertentu, jadi referensi ke tabel users
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->decimal('pending_balance', 15, 2)->default(0);
            $table->decimal('available_balance', 15, 2)->default(0);
            $table->decimal('total_income', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('seller_wallets');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (seller)
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            // Relasi ke tabel bookings (opsional, karena kalau withdraw tidak ada booking_id)
            $table->foreignId('booking_id')->nullable()->constrained('bookings')->onDelete('set null');
            
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['income', 'withdrawal', 'refund', 'fee']);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending');
            $table->text('description')->nullable();
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
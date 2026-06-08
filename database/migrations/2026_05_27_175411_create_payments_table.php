<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained('bookings')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('transaction_id')->nullable()->unique();
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->decimal('gross_amount', 15, 2);
            $table->enum('transaction_status', ['unpaid', 'pending', 'paid', 'failed', 'expired', 'cancelled'])->default('unpaid');
            $table->string('fraud_status')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
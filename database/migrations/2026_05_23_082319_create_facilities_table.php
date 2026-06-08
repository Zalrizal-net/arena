<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (khusus role seller)
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('city');
            $table->text('address');
            $table->text('description');
            
            // Menggunakan decimal untuk presisi harga (12 digit total, 2 di belakang koma)
            $table->decimal('price_per_hour', 12, 2); 
            $table->string('thumbnail')->nullable();
            
            // Status operasional fasilitas
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');
            
            // Koordinat peta (opsional)
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            $table->timestamps();
            $table->softDeletes(); // Menambahkan soft deletes agar data tidak benar-benar hilang saat dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facilities');
    }
};
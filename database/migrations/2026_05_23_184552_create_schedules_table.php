<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
            
            $table->tinyInteger('day_of_week')->comment('1=Senin, 2=Selasa, 3=Rabu, 4=Kamis, 5=Jumat, 6=Sabtu, 7=Minggu');
            $table->time('open_time');
            $table->time('close_time');
            $table->integer('slot_duration')->default(60)->comment('Durasi per sesi dalam menit');
            
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();

            $table->unique(['facility_id', 'day_of_week'], 'facility_day_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedules');
    }
};
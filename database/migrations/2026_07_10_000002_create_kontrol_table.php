<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kontrol', function (Blueprint $table) {
            $table->id();
            $table->enum('mode', ['Otomatis', 'Manual'])->default('Otomatis');
            $table->enum('heater', ['ON', 'OFF'])->default('OFF');
            $table->enum('motor', ['ON', 'OFF'])->default('OFF');
            $table->enum('kipas', ['ON', 'OFF'])->default('OFF');
            $table->decimal('target_suhu', 4, 1)->default(37.5);
            $table->integer('target_kelembapan')->default(65);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kontrol');
    }
};

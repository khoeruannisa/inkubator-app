<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inkubator', function (Blueprint $table) {
            $table->id();
            $table->float('suhu')->nullable();
            $table->float('kelembapan')->nullable();
            $table->string('status', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inkubator');
    }
};

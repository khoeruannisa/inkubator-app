<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kontrol', function (Blueprint $table) {
            if (!Schema::hasColumn('kontrol', 'motor_last_on')) {
                $table->timestamp('motor_last_on')->nullable()->after('target_kelembapan');
            }
            if (!Schema::hasColumn('kontrol', 'motor_interval_jam')) {
                $table->unsignedTinyInteger('motor_interval_jam')->default(3)->after('motor_last_on');
            }
            if (!Schema::hasColumn('kontrol', 'motor_durasi_menit')) {
                $table->unsignedTinyInteger('motor_durasi_menit')->default(5)->after('motor_interval_jam');
            }
        });
    }

    public function down(): void
    {
        Schema::table('kontrol', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('kontrol', 'motor_last_on')) $columnsToDrop[] = 'motor_last_on';
            if (Schema::hasColumn('kontrol', 'motor_interval_jam')) $columnsToDrop[] = 'motor_interval_jam';
            if (Schema::hasColumn('kontrol', 'motor_durasi_menit')) $columnsToDrop[] = 'motor_durasi_menit';
            
            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};

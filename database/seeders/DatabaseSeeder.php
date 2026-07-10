<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed user admin awal
        DB::table('users')->insertOrIgnore([
            'name'       => 'Admin Inkubator',
            'email'      => 'admin@inkubator.com',
            'password'   => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Seed row kontrol awal (id=1 selalu harus ada)
        // Seluruh controller bergantung pada baris ini
        DB::table('kontrol')->insertOrIgnore([
            'id'                 => 1,
            'mode'               => 'Otomatis',
            'heater'             => 'OFF',
            'motor'              => 'OFF',
            'kipas'              => 'OFF',
            'target_suhu'        => 37.5,
            'target_kelembapan'  => 65,
            'created_at'         => now(),
            'updated_at'         => now(),
        ]);
    }
}


<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::insert([
            ['key' => 'jam_masuk', 'value' => '09:00:00'],
            ['key' => 'jam_pulang', 'value' => '16:00:00'],
            ['key' => 'potongan_gaji_per_jam', 'value' => '15000'],
        ]);
    }
}
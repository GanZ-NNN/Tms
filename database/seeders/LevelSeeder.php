<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Level::create(['name' => 'ระดับเริ่มต้น']);
        \App\Models\Level::create(['name' => 'ระดับกลาง']);
        \App\Models\Level::create(['name' => 'ระดับสูง']);
    }
}

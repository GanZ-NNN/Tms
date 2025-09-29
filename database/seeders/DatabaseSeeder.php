<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\TrainingSession; // <-- เราจะใช้ตัวนี้เป็นหลัก
// use App\Models\Session; // <-- ตัวนี้อาจจะทำให้สับสน ลบออกได้
use App\Models\Trainer;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- 1. สร้าง Users (Admin & Trainees) ---
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::factory(10)->create(['role' => 'trainee']);

        // --- 2. สร้าง Master Data (Categories, Levels, Trainers) ---
        
        $a = Category::create(['name' => 'Artificial Intelligence (AI) & Automation']);
        $b = Category::create(['name' => 'Block chain & BIM (Building Information Modeling)']);
        $c = Category::create(['name' => 'Coding, CAD&CAM, Cloud']);
        $d = Category::create(['name' => 'Digital Media, Data, Drone']);
        $e = Category::create(['name' => 'Entrepreneurship, Emerging technologies']);
        $f = Category::create(['name' => 'Full Stack Developer']);

        Level::create(['name' => 'ระดับเริ่มต้น']);
        Level::create(['name' => 'ระดับกลาง']);
        Level::create(['name' => 'ระดับสูง']);
        
        Trainer::factory(5)->create();

        // --- 3. สร้าง Programs (ที่ต้องพึ่งพา Categories) ---
    
        Program::factory(2)->create(['category_id' => $a->id]);
        Program::factory(2)->create(['category_id' => $b->id]);
        Program::factory(2)->create(['category_id' => $c->id]);
        Program::factory(2)->create(['category_id' => $d->id]);
        Program::factory(2)->create(['category_id' => $e->id]);
        Program::factory(2)->create(['category_id' => $f->id]);

        // --- 4. สร้าง TrainingSessions (ที่ต้องพึ่งพา Programs, Trainers, Levels) ---
        TrainingSession::factory(20)->create();
    }
}
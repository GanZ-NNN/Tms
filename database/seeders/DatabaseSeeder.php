<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\Session;
use App\Models\Trainer;
use App\Models\Category;
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
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
        ]);

        User::factory(10)->create(['role' => 'trainee']);

        // --- 2. สร้าง Categories ---
        
        $a = Category::create(['name' => 'Artificial Intelligence (AI) & Automation']);
        $b = Category::create(['name' => 'Block chain & BIM (Building Information Modeling)']);
        $c = Category::create(['name' => 'Coding, CAD&CAM, Cloud']);
        $d = Category::create(['name' => 'Digital Media, Data, Drone']);
        $e = Category::create(['name' => 'Entrepreneurship, Emerging technologies']);
        $f = Category::create(['name' => 'Full Stack Developer']);
        
        // --- 3. สร้าง Trainers ---
        Trainer::factory(5)->create();

        // --- 4. สร้าง Programs และกำหนด Category ID ---
    
        Program::factory(2)->create(['category_id' => $a->id]);
        Program::factory(2)->create(['category_id' => $b->id]);
        Program::factory(2)->create(['category_id' => $c->id]);
        Program::factory(2)->create(['category_id' => $d->id]);
        Program::factory(2)->create(['category_id' => $e->id]);
        Program::factory(count: 2)->create(['category_id' => $f->id]);

   

        // --- 5. สร้าง Sessions ---
        Session::factory(20)->create();
    }
}
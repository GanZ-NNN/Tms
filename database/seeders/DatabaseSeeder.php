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
        $webDev = Category::create(['name' => 'Web Development']);
        $dataSci = Category::create(['name' => 'Data Science']);
        $marketing = Category::create(['name' => 'Digital Marketing']);
        $pm = Category::create(['name' => 'Project Management']);
        
        // --- 3. สร้าง Trainers ---
        Trainer::factory(5)->create();

        // --- 4. สร้าง Programs และกำหนด Category ID ---
        Program::factory(3)->create(['category_id' => $webDev->id]);
        Program::factory(2)->create(['category_id' => $dataSci->id]);
        Program::factory(2)->create(['category_id' => $marketing->id]);
        Program::factory(2)->create(['category_id' => $pm->id]);

        $this->call(LevelSeeder::class);

        // --- 5. สร้าง Sessions ---
        Session::factory(20)->create();
    }
}
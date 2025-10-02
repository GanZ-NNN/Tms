<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Trainer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use App\Models\Level;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Session>
 */
class SessionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // --- Foreign Keys (สุ่มจากข้อมูลที่มีอยู่จริง) ---
            'program_id' => Program::inRandomOrder()->first()->id,
            'trainer_id' => Trainer::inRandomOrder()->first()->id,
            'level_id'   => Level::inRandomOrder()->first()->id, 

            
            // --- Session Details (ตามโครงสร้างฐานข้อมูลของคุณ) ---
            'session_number'        => $this->faker->numberBetween(1, 5), // รอบที่ 1-5
            'location'              => $this->faker->address,
            'capacity'              => $this->faker->randomElement([15, 20, 25, 30]),
            'status'                => 'scheduled',

            'title' => 'Batch #' . $this->faker->unique()->numberBetween(100, 999) . ' - ' . $this->faker->monthName(),
            
            // --- Date and Time Logic ---
            'start_at'              => $this->faker->dateTimeBetween('+2 weeks', '+4 months'),
            
            'end_at' => function (array $attributes) {
                // จบหลังวันเริ่ม 1-3 วัน
                return Carbon::parse($attributes['start_at'])->addDays(rand(1, 3));
            },
            
            'registration_start_at' => function (array $attributes) {
                // เริ่มรับสมัคร 2 สัปดาห์ก่อนวันเริ่ม
                return Carbon::parse($attributes['start_at'])->subWeeks(2);
            },
            
            'registration_end_at' => function (array $attributes) {
                // ปิดรับสมัคร 1 วันก่อนวันเริ่ม
                return Carbon::parse($attributes['start_at'])->subDay();
            },
        ];
    }
}
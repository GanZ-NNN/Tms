<?php

namespace Database\Factories;

use App\Models\Program;
use App\Models\Trainer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

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
            // สุ่ม Program ID และ Trainer ID จากข้อมูลที่มีอยู่จริง
            'program_id' => Program::inRandomOrder()->first()->id,
            'trainer_id' => Trainer::inRandomOrder()->first()->id,

            //'title' => $this->faker->bs(),
            'start_at' => $this->faker->dateTimeBetween('+1 week', '+3 months'),
            
            // ทำให้ end_at เป็นวันที่หลังจาก start_at เสมอ
            'end_at' => function (array $attributes) {
                return Carbon::parse($attributes['start_at'])->addDays(rand(1, 4))->addHours(rand(2, 8));
            },
            
            //'capacity' => $this->faker->numberBetween(15, 50),
            'location' => $this->faker->address(),
            'status' => 'scheduled',
        ];
    }
}
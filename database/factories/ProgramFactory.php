<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => rtrim($this->faker->sentence(rand(3, 6)), '.'),
            'description' => $this->faker->paragraph(3),
            
            // สุ่ม Category ID จากข้อมูลที่มีอยู่จริง
            'category_id' => Category::inRandomOrder()->first()->id,
        ];
    }
}
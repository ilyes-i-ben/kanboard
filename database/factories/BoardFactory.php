<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    protected $model = Board::class;

    public function definition(): array
    {
        $colors = ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6', '#1abc9c', '#34495e', '#e67e22', '#95a5a6', '#27ae60'];

        return [
            'title' => fake()->words(rand(2, 4), true),
            'description' => fake()->boolean(80) ? fake()->sentence() : null,
            'background_color' => fake()->randomElement($colors),
            'created_by' => User::factory(),
            'created_at' => fake()->dateTimeBetween('-6 months', '-1 week'),
            'updated_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}

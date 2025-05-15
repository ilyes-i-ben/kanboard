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
        $colors = ['#3498db', '#2ecc71', '#e74c3c', '#f39c12', '#9b59b6', '#1abc9c', '#34495e'];

        return [
            'title' => fake()->words(rand(2, 4), true),
            'background_color' => fake()->randomElement($colors),
            'created_by' => User::factory(), // Will create a User if none provided
            'created_at' => fake()->dateTimeBetween('-6 months', '-1 week'),
            'updated_at' => fake()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}

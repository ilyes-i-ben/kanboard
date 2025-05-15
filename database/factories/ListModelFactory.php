<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\ListModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class ListModelFactory extends Factory
{
    protected $model = ListModel::class;

    public function definition(): array
    {
        return [
            'board_id' => Board::factory(),
            'title' => fake()->words(rand(1, 3), true),
            'position' => fake()->randomFloat(3, 0, 1000),
            'created_at' => fake()->dateTimeBetween('-3 months', '-2 weeks'),
            'updated_at' => fake()->dateTimeBetween('-2 weeks', 'now'),
        ];
    }
}

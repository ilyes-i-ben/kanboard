<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\ListModel;
use App\Models\User;
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
            'is_terminal' => fake()->boolean(20),
            'created_by' => User::factory(),
            'created_at' => fake()->dateTimeBetween('-3 months', '-2 weeks'),
            'updated_at' => fake()->dateTimeBetween('-2 weeks', 'now'),
        ];
    }

    public function terminal(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'is_terminal' => true,
            ];
        });
    }
}

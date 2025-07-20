<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\ListModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-2 months', '-1 week');
        $hasDeadline = fake()->boolean(70); // 70% chance of having a deadline
        $isFinished = $hasDeadline && fake()->boolean(40); // 40% chance of being finished if it has a deadline

        return [
            'list_id' => ListModel::factory(),
            'title' => fake()->sentence(rand(3, 8)),
            'description' => fake()->boolean(80) ? fake()->paragraphs(rand(1, 3), true) : null,
            'position' => fake()->randomFloat(3, 0, 1000),
            'deadline' => $hasDeadline ? fake()->dateTimeBetween('+1 day', '+2 months') : null,
            'finished_at' => $isFinished ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'created_by' => User::factory(),
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }

    // A state for cards that are finished
    public function finished(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'deadline' => fake()->dateTimeBetween('-1 month', '-1 day'),
                'finished_at' => fake()->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }

    // A state for cards that are overdue
    public function overdue(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'deadline' => fake()->dateTimeBetween('-1 month', '-1 day'),
                'finished_at' => null,
            ];
        });
    }
}

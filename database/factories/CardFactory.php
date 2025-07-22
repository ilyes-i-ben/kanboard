<?php

namespace Database\Factories;

use App\Models\Card;
use App\Models\ListModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CardFactory extends Factory
{
    protected $model = Card::class;

    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-2 months', '-1 week');
        $hasDeadline = fake()->boolean(70);
        $isFinished = $hasDeadline && fake()->boolean(40);

        return [
            'list_id' => ListModel::factory(),
            'title' => fake()->sentence(rand(3, 8)),
            'description' => fake()->boolean(80) ? fake()->paragraphs(rand(1, 3), true) : null,
            'position' => fake()->randomFloat(3, 0, 1000),
            'priority' => fake()->randomElement(['low', 'medium', 'high']),
            'deadline' => $hasDeadline ? fake()->dateTimeBetween('+1 day', '+2 months') : null,
            'finished_at' => $isFinished ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'category_id' => null, // gonnabe set in seeder when categories exist
            'public_token' => fake()->boolean(30) ? Str::random(32) : null,
            'created_by' => User::factory(),
            'created_at' => $createdAt,
            'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
        ];
    }

    public function finished(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'deadline' => fake()->dateTimeBetween('-1 month', '-1 day'),
                'finished_at' => fake()->dateTimeBetween('-1 week', 'now'),
            ];
        });
    }

    public function overdue(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'deadline' => fake()->dateTimeBetween('-1 month', '-1 day'),
                'finished_at' => null,
            ];
        });
    }

    public function highPriority(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'priority' => 'high',
            ];
        });
    }

    public function public(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'public_token' => Str::random(32),
            ];
        });
    }
}

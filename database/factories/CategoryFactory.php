<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $categories = [
            'Marketing', 'Development', 'Business Development', 'Design', 'Sales',
            'Customer Support', 'HR', 'Finance', 'Operations', 'Research',
            'Content Creation', 'Social Media', 'Analytics', 'Quality Assurance',
            'Product Management', 'Strategy', 'Legal', 'Partnerships'
        ];

        return [
            'name' => fake()->randomElement($categories),
            'board_id' => Board::factory(),
        ];
    }
}

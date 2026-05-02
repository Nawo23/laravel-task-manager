<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'title'       => $this->faker->sentence(5, true),
            'description' => $this->faker->optional(0.7)->paragraph(),
            'status'      => $this->faker->randomElement(['pending', 'done']),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function done(): static
    {
        return $this->state(['status' => 'done']);
    }
}

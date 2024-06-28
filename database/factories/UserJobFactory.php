<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserJob>
 */
class UserJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['rejected', 'approved'];
        $userId=User::inRandomOrder()->first()->id;
        return [
            'user_id' => $userId,
            'title' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'location' => $this->faker->city,
            'description' => $this->faker->paragraph,
            'application_instructions' => $this->faker->sentence,
            'status' => $this->faker->optional()->randomElement($statuses),
        ];
    }
}

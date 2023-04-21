<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->name(),
            'last_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'login_code' => rand(1000, 9999),
            'password' => bcrypt('123456789'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverifiedEmail(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverifiedPhone(): static
    {
        return $this->state(fn(array $attributes) => [
            'phone_verified_at' => null,
        ]);
    }
}

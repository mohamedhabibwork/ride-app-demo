<?php

namespace Database\Factories;

use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Driver>
 */
class DriverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'year' => mt_rand(2000, 2022),
            'make' => $this->withFaker()->randomAscii(),
            'model' => $this->withFaker()->randomAscii(),
            'color' => $this->withFaker()->colorName(),
            'license_plate' => $this->withFaker()->randomAscii(),
            'status' => $this->withFaker()->boolean(),
            'balance' => $this->withFaker()->randomFloat(2, 0, 1000),
        ];
    }
}

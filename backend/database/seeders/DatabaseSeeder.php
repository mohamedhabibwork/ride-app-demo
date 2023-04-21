<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->has(Driver::factory(state: ['status' => true]), 'driver')
            ->create([
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@app.com',
                'phone' => '01098989297',
                'login_code' => 4894,
            ]);

        User::factory()
            ->create([
                'first_name' => 'Tester',
                'last_name' => 'Tester',
                'email' => 'test@app.com',
                'phone' => '01098989296',
                'login_code' => 4894,
            ]);

        User::factory()
            ->create([
                'first_name' => 'Passenger',
                'last_name' => 'Passenger',
                'email' => 'passenger@app.com',
                'phone' => '01098989295',
                'login_code' => 4894,
            ]);

        $this->call([
            DriverSeeder::class,
            TripSeeder::class,
        ]);


    }
}

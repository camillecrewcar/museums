<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Creating 50 users
        for ($i = 1; $i <= 50; $i++) {
            User::create([
                'login' => $faker->userName,
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'role' => 2, // Assigning role value of 2 to all users
                'email' => $faker->email,
                'password' => Hash::make('password'.$i),
            ]);
        }

        // Creating admin user
        User::create([
            'login' => 'admin',
            'name' => 'Admin',
            'surname' => 'User',
            'role' => 1, // Assigning role value of 1 to the admin user
            'email' => 'admin@example.com',
            'password' => Hash::make('adminpassword'),
        ]);
    }
}

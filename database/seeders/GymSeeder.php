<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gym;

class GymSeeder extends Seeder
{
    public function run(): void
    {
        Gym::firstOrCreate(
            ['slug' => 'global-fitness'],
            [
                'name' => 'Global Fitness Gym',
                'email' => 'info@gym.com',
                'phone' => '+250788000000',
                'country' => 'Rwanda',
                'city' => 'Kigali',
                'address' => 'Kigali Center',
                'active' => true,
            ]
        );
    }
}
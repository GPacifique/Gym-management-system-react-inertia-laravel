<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | SUPER ADMIN
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gymmate.com',
            'phone' => '0780000000',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
            'email_notifications' => true,
            'sms_notifications' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | BUSINESS OWNER
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Business Owner',
            'email' => 'owner@gymmate.com',
            'phone' => '0780000001',
            'password' => Hash::make('password'),
            'role' => 'business_owner',
            'email_notifications' => true,
            'sms_notifications' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | MANAGER
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Gym Manager',
            'email' => 'manager@gymmate.com',
            'phone' => '0780000002',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'email_notifications' => true,
            'sms_notifications' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | RECEPTIONIST
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Receptionist',
            'email' => 'reception@gymmate.com',
            'phone' => '0780000003',
            'password' => Hash::make('password'),
            'role' => 'receptionist',
            'email_notifications' => true,
            'sms_notifications' => false,
        ]);

        /*
        |--------------------------------------------------------------------------
        | TRAINER
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Fitness Trainer',
            'email' => 'trainer@gymmate.com',
            'phone' => '0780000004',
            'password' => Hash::make('password'),
            'role' => 'trainer',
            'email_notifications' => true,
            'sms_notifications' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | MEMBER
        |--------------------------------------------------------------------------
        */
        User::create([
            'name' => 'Gym Member',
            'email' => 'member@gymmate.com',
            'phone' => '0780000005',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_notifications' => true,
            'sms_notifications' => false,
        ]);
    }
}
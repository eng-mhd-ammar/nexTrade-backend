<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Auth\Models\User;
use Modules\Auth\Models\UserType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        UserType::create(['name' => 'Admin']);
        UserType::create(['name' => 'User']);
        UserType::create(['name' => 'Delivery']);

        User::create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => '11223344',
            'email_verified_at' => now(),
            'user_type_id' => 2,
        ]);
    }
}

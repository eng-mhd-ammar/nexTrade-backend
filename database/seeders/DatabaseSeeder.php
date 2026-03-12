<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
    }
}

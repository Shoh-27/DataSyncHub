<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->freelancer()->count(5)->create();

        \App\Models\User::factory()->client()->count(5)->create();

        \App\Models\User::factory()->suspended()->count(3)->create();
    }
}

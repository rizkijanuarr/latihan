<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Exam : Seeder
            UserSeeder::class,
            CategorySeeder::class,
        ]);
        // Exam : Factory
        \App\Models\Post::factory(50)->create();
    }
}

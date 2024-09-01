<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    //
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'Mas Ikyy',
            'email'  => 'masikyy@id.rizkijanuar.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
    }
}

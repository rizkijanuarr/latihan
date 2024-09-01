<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    //
    public function run(): void
    {
        collect([
            'Laravel',
            'Symfony',
            'Django',
            'Ruby on Rails',
            'Spring',
            'Express',
            'Angular',
            'React',
            'Vue.js',
            'Flutter',
        ])->each(fn($category) => \App\Models\Category::query()->create(['name' => $category, 'slug' => Str::slug($category)]));
    }
}

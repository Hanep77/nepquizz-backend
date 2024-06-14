<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->create([
            "title" => "Programming",
            "slug" => "programming"
        ]);

        Category::factory()->create([
            "title" => "Sport",
            "slug" => "sport"
        ]);

        Category::factory()->create([
            "title" => "Math",
            "slug" => "math"
        ]);
    }
}

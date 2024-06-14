<?php

namespace Database\Seeders;

use App\Models\Difficulity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DifficulitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Difficulity::factory()->create([
            "title" => "Easy",
            "slug" => "Easy"
        ]);

        Difficulity::factory()->create([
            "title" => "Medium",
            "slug" => "medium"
        ]);
        Difficulity::factory()->create([
            "title" => "Hard",
            "slug" => "hard"
        ]);
    }
}

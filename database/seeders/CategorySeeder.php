<?php

namespace Database\Seeders;

use App\Models\Ad;
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
        Category::factory()->has(Ad::factory()->forAnnouncer()->count(3))->count(30)->create();
    }
}

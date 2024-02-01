<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Announcer;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Announcer::factory()->count(30)->create();
         Announcer::factory()->count(20)
->has(Ad::factory()->count(3)->forCategory(["name"=>"chair"]))
->create();
    }
}

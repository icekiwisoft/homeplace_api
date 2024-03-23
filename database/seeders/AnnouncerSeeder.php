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
        Announcer::factory()->count(10)->create();

    }
}

<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\Announcer;
use App\Models\Media;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $announcer=Announcer::factory()->state([
            "name" => "nguewo",
        ])->create();
        $medias= Media::factory()->count(10)->for($announcer);
        
        Ad::factory()
        ->count(20)
        ->state([
            "category_id"=>1
            
        ])
        ->for($announcer)
        ->has($medias,"medias")->create();
    }
}

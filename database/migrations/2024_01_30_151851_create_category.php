<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->ulid("id");
            $table->timestamps();
            $table->integer("type")->default(0); // 0 for house, 1 for furniture
            $table->string('name')->unique();
        });

        // Create house categories
        Category::create([
            "type" => 0,
            "name" => "Apartment"
        ]);
        Category::create([
            "type" => 0,
            "name" => "Room"
        ]);
        Category::create([
            "type" => 0,
            "name" => "House"
        ]);
        Category::create([
            "type" => 0,
            "name" => "Studio"
        ]);

        // Create furniture categories
        Category::create([
            "type" => 1,
            "name" => "Sofas"
        ]);
        Category::create([
            "type" => 1,
            "name" => "Tables"
        ]);
        Category::create([
            "type" => 1,
            "name" => "Chairs"
        ]);
        Category::create([
            "type" => 1,
            "name" => "Beds"
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

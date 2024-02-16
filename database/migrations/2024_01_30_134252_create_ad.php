<?php

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
        Schema::create('ads', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->integer("item_type")->default(0); //0 for house and 1 for furniture

            $table->integer("price")->default(0);
            $table->integer("toilet")->unsigned()->nullable();
            $table->integer("kitchen")->unsigned()->nullable();
            $table->integer("height")->unsigned()->nullable();
            $table->integer("width")->unsigned()->nullable();
            $table->integer("length")->unsigned()->nullable();
            $table->integer("weight")->unsigned()->nullable();


            $table->integer("bedroom")->unsigned()->default(0);
            $table->integer("mainroom")->unsigned()->default(0);
            $table->integer("ad_type")->default(1); //0 for location 1 for sale
            $table->string("announcer_id")->nullable();
            $table->string("category_id")->nullable();
            $table->string("presentation_img")->nullable();

            $table->timestamps();
            $table->text("description")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad');
    }
};

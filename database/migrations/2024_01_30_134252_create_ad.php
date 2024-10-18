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
            $table->string("item_type");

            $table->float("price")->default(0);

            $table->boolean("ad_type"); //0 for sell and 1 for location
            $table->unsignedBigInteger("ad_id");
            $table->string("announcer_id")->nullable();
            $table->string("category_id")->nullable();

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

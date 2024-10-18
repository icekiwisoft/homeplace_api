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
        Schema::create('real_estates', function (Blueprint $table) {
            $table->id();
            $table->integer("toilet")->unsigned()->default(0);
            $table->integer("kitchen")->unsigned()->default(0);
            $table->integer("bedroom")->unsigned()->default(0);
            $table->integer("mainroom")->unsigned()->default(0);
            $table->float("lng")->nullable();
            $table->float("lat")->nullable();
            $table->float("caution")->nullable();
            $table->boolean("barrier")->default(false);
            $table->boolean("garage")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('real_estates');
    }
};

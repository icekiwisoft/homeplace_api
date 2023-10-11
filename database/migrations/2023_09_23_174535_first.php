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
        Schema::create('house', function (Blueprint $table) {
            $table->id();
            $table->integer("price")->default(0);
            $table->integer("toilet")->unsigned();
            $table->integer("kitchen")->unsigned();
            $table->integer("bedroom")->unsigned();
            $table->integer("mainroom")->unsigned();
            $table->integer("type")->default(0);
            $table->timestamps();
            $table->text("description")->nullable();
            $table->foreign("announcer_id", "announcers")->references("id");
        });


        Schema::create('announcers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->timestamps();
            $table->string('name');
        });


        Schema::create('furnitures', function (Blueprint $table) {
            $table->id();
            $table->integer('pricing')->default(0);
            $table->timestamps();
            $table->string('name');
            $table->text("description")->nullable();
            $table->foreign("category_id", "furniturecategories")->references("id");
            $table->foreign("announcer_id", "announcers")->references("id");
            $table->boolean("new")->default(true);
        });

        Schema::create('furniturecategories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house');

        Schema::dropIfExists('announcers');

        Schema::dropIfExists('furniturecategories');
        Schema::dropIfExists('furnitures');
    }
};

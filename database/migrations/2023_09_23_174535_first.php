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

        Schema::create('announcers', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->timestamps();
            $table->string('name');
        });

        Schema::create('homecategories', function (Blueprint $table) {
            $table->timestamps();
            $table->string('name')->primary();
        });

        Schema::create('house', function (Blueprint $table) {
            $table->id();
            $table->integer("price")->default(0);
            $table->integer("toilet")->unsigned();
            $table->integer("kitchen")->unsigned();
            $table->integer("bedroom")->unsigned();
            $table->integer("mainroom")->unsigned();
            $table->integer("type")->default(0);
            $table->unsignedBigInteger("announcer_id");
            $table->string("category_id");

            $table->timestamps();
            $table->text("description")->nullable();
            $table->foreign("category_id")->references("name")->on("homecategories");

            $table->foreign("announcer_id")->references("id")->on("announcers")->onDelete("cascade");
        });




        Schema::create('furniturecategories', function (Blueprint $table) {
            $table->timestamps();
            $table->string('name')->primary();
        });



        Schema::create('furnitures', function (Blueprint $table) {
            $table->id();
            $table->integer('pricing')->default(0);
            $table->timestamps();
            $table->string('name');
            $table->text("description")->nullable();
            $table->unsignedBigInteger("announcer_id");
            $table->string("category_id");

            $table->foreign("category_id")->references("name")->on("furniturecategories");
            $table->foreign("announcer_id")->references("id")->on("announcers");
            $table->boolean("new")->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house');

        Schema::dropIfExists('announcers');
        Schema::dropIfExists('homecategories');


        Schema::dropIfExists('furniturecategories');
        Schema::dropIfExists('furnitures');
    }
};

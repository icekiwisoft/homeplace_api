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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
                        $table->unsignedBigInteger('subscription_type_id');
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types');
            $table->decimal('price',  10, 2); // Adjust precision as needed
            $table->integer('duration_in_days')->default(10);
            $table->integer('initial_credits')->default(10);
            $table->string('status')->default('active');
            $table->date('start_date');
            $table->date('end_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

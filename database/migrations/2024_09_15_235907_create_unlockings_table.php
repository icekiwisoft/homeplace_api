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
        Schema::create('unlockings', function (Blueprint $table) {
            $table->id();
            $table->string('ad_id')->constrained()->on('ads')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->on('users')->onDelete('cascade');
            $table->timestamp('unlocked_at');
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unlockings');
    }
};

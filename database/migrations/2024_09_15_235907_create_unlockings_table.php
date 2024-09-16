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
            $table->foreignId('user_id')->constrained("users")->onDelete('cascade');
            $table->foreignId('house_id')->constrained('ads')->onDelete('cascade'); // Assuming there's a houses table
            $table->timestamp('unlocked_at');
            $table->timestamp('expires_at');
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

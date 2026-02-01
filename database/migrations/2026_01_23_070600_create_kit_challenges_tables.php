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
        Schema::create('kit_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('image_path'); // Zoomed-in kit detail
            $table->string('full_image_path')->nullable(); // Full kit image revealed after correct answer
            $table->string('team_name'); // The team part of the answer
            $table->string('kit_year'); // The year part of the answer (e.g., 2023-24)
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->timestamps();
        });

        Schema::create('kit_hints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kit_challenge_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kit_hints');
        Schema::dropIfExists('kit_challenges');
    }
};

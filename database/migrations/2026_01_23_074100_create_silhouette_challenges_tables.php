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
        Schema::create('silhouette_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('image_path'); // Silhouette image
            $table->string('reveal_image_path')->nullable(); // Optional full image to reveal
            $table->string('player_name'); // The answer
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->timestamps();
        });

        Schema::create('silhouette_hints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('silhouette_challenge_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('silhouette_hints');
        Schema::dropIfExists('silhouette_challenges');
    }
};

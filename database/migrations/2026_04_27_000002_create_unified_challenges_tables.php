<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->enum('stimulus_type', ['image', 'video', 'text', 'scrambled_text', 'sequence'])->default('text');
            $table->json('stimulus_data')->nullable(); // Flexible JSON for per-game-type fields
            $table->string('answer'); // Primary answer
            $table->json('answers')->nullable(); // For multi-answer games (transfer chain, group)
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('challenge_hints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenge_hints');
        Schema::dropIfExists('challenges');
    }
};

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
            $table->json('stimulus_data')->nullable();
            $table->string('answer');
            $table->json('answers')->nullable();
            $table->string('answer_type')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('challenges');
    }
};

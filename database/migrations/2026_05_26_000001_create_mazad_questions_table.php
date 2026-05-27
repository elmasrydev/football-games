<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mazad_questions', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->string('text_ar')->nullable();
            $table->string('category');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->json('accepted_answers'); // [1, 2, 3, ... (GameItem IDs)]
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mazad_questions');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mazad_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('code', 6)->unique();
            $table->foreignId('owner_id')->constrained('users')->cascadeOnDelete();
            $table->enum('visibility', ['public', 'private'])->default('public');
            $table->enum('status', ['waiting', 'starting', 'in_progress', 'finished', 'closed'])->default('waiting');
            $table->unsignedSmallInteger('max_players')->default(10);
            $table->unsignedSmallInteger('min_players_to_start')->default(2);
            $table->unsignedSmallInteger('auto_start_at')->nullable();
            $table->unsignedSmallInteger('num_questions')->default(5);
            $table->unsignedSmallInteger('question_time_seconds')->default(60);
            $table->unsignedSmallInteger('rest_time_seconds')->default(10);
            $table->enum('mode', ['individual', 'teams'])->default('individual');
            $table->unsignedSmallInteger('num_teams')->nullable();
            $table->unsignedSmallInteger('current_question_index')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mazad_rooms');
    }
};

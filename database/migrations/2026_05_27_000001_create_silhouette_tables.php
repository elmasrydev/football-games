<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('silhouette_rooms', function (Blueprint $table) {
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
            $table->enum('language', ['en', 'ar', 'mix'])->default('mix');
            $table->json('genres')->nullable();
            $table->unsignedSmallInteger('num_teams')->nullable();
            $table->unsignedSmallInteger('current_question_index')->default(0);
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamps();
        });

        Schema::create('silhouette_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('silhouette_rooms')->cascadeOnDelete();
            $table->string('name');
            $table->string('color', 7)->default('#6366f1');
            $table->timestamps();
        });

        Schema::create('silhouette_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('silhouette_rooms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('silhouette_teams')->nullOnDelete();
            $table->boolean('is_owner')->default(false);
            $table->boolean('is_connected')->default(true);
            $table->unsignedInteger('total_score')->default(0);
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('disconnected_at')->nullable();

            $table->unique(['room_id', 'user_id']);
        });

        Schema::create('silhouette_room_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('silhouette_rooms')->cascadeOnDelete();
            $table->foreignId('challenge_id')->constrained('challenges')->cascadeOnDelete();
            $table->unsignedSmallInteger('question_order');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });

        Schema::create('silhouette_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_question_id')->constrained('silhouette_room_questions')->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('silhouette_players')->cascadeOnDelete();
            $table->string('answer_text');
            $table->foreignId('game_item_id')->nullable()->constrained('game_items')->cascadeOnDelete();
            $table->boolean('is_correct')->default(false);
            $table->boolean('is_winning')->default(false);
            $table->timestamp('submitted_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('silhouette_answers');
        Schema::dropIfExists('silhouette_room_questions');
        Schema::dropIfExists('silhouette_players');
        Schema::dropIfExists('silhouette_teams');
        Schema::dropIfExists('silhouette_rooms');
    }
};

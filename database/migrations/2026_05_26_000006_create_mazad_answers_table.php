<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mazad_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_question_id')->constrained('mazad_room_questions')->cascadeOnDelete();
            $table->foreignId('player_id')->constrained('mazad_players')->cascadeOnDelete();
            $table->string('answer_text');
            $table->foreignId('game_item_id')->nullable()->constrained('game_items')->cascadeOnDelete();
            $table->boolean('is_correct')->default(false);
            $table->timestamp('submitted_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mazad_answers');
    }
};

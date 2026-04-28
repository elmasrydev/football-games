<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_chain_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->string('club_a');
            $table->string('club_b');
            $table->json('answers');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('transfer_chain_hints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_chain_challenge_id', 'tcc_id_hint_fk')->constrained('transfer_chain_challenges')->onDelete('cascade');
            $table->text('content');
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_chain_hints');
        Schema::dropIfExists('transfer_chain_challenges');
    }
};

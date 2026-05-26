<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mazad_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('mazad_rooms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('team_id')->nullable()->constrained('mazad_teams')->nullOnDelete();
            $table->boolean('is_owner')->default(false);
            $table->boolean('is_connected')->default(true);
            $table->unsignedInteger('total_score')->default(0);
            $table->timestamp('joined_at')->useCurrent();
            $table->timestamp('disconnected_at')->nullable();

            $table->unique(['room_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mazad_players');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mazad_room_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('mazad_rooms')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('mazad_questions')->cascadeOnDelete();
            $table->unsignedSmallInteger('question_order');
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mazad_room_questions');
    }
};

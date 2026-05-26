<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mazad_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('mazad_rooms')->cascadeOnDelete();
            $table->string('name');
            $table->string('color', 7)->default('#6366f1'); // hex color
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mazad_teams');
    }
};

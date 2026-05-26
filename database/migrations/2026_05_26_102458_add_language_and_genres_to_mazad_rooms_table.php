<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mazad_rooms', function (Blueprint $table) {
            $table->enum('language', ['en', 'ar', 'mix'])->default('mix')->after('mode');
            $table->json('genres')->nullable()->after('language');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mazad_rooms', function (Blueprint $table) {
            $table->dropColumn(['language', 'genres']);
        });
    }
};

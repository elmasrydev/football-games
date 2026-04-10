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
        Schema::table('kit_challenges', function (Blueprint $table) {
            $table->dropColumn('kit_year');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kit_challenges', function (Blueprint $table) {
            $table->string('kit_year')->nullable()->after('team_name');
        });
    }
};

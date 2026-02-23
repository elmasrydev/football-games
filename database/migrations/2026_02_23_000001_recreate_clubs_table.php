<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key in career_clubs first
        if (Schema::hasTable('career_clubs')) {
            Schema::table('career_clubs', function (Blueprint $table) {
                try {
                    $table->dropForeign(['club_id']);
                } catch (\Exception $e) {
                }
            });
        }

        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clubs');
        Schema::enableForeignKeyConstraints();

        Schema::create('clubs', function (Blueprint $table) {
            $table->unsignedBigInteger('club_id')->primary();
            $table->string('club_code')->nullable();
            $table->string('name')->index();
            $table->string('domestic_competition_id')->nullable();
            $table->string('total_market_value')->nullable();
            $table->unsignedSmallInteger('squad_size')->nullable();
            $table->decimal('average_age', 4, 1)->nullable();
            $table->unsignedSmallInteger('foreigners_number')->nullable();
            $table->decimal('foreigners_percentage', 4, 1)->nullable();
            $table->unsignedSmallInteger('national_team_players')->nullable();
            $table->string('stadium_name')->nullable();
            $table->unsignedInteger('stadium_seats')->nullable();
            $table->string('net_transfer_record')->nullable();
            $table->string('coach_name')->nullable();
            $table->unsignedSmallInteger('last_season')->nullable();
            $table->string('filename')->nullable();
            $table->text('url')->nullable();
            $table->timestamps();
        });

        // Truncate career_clubs before re-adding foreign key because IDs will change
        if (Schema::hasTable('career_clubs')) {
            DB::table('career_clubs')->truncate();
            
            Schema::table('career_clubs', function (Blueprint $table) {
                $table->foreign('club_id')->references('club_id')->on('clubs')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('career_clubs', function (Blueprint $table) {
            try {
                $table->dropForeign(['club_id']);
            } catch (\Exception $e) {}
        });
        
        Schema::dropIfExists('clubs');
    }
};

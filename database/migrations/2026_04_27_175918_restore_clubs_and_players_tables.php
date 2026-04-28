<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('players', function (Blueprint $table) {
            $table->unsignedBigInteger('player_id')->primary();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->index();
            $table->unsignedSmallInteger('last_season')->nullable();
            $table->unsignedBigInteger('current_club_id')->nullable();
            $table->string('player_code')->nullable();
            $table->string('country_of_birth')->nullable();
            $table->string('city_of_birth')->nullable();
            $table->string('country_of_citizenship')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('sub_position')->nullable();
            $table->string('position')->nullable();
            $table->string('foot')->nullable();
            $table->unsignedSmallInteger('height_in_cm')->nullable();
            $table->string('contract_expiration_date')->nullable();
            $table->string('agent_name')->nullable();
            $table->text('image_url')->nullable();
            $table->text('url')->nullable();
            $table->string('current_club_domestic_competition_id')->nullable();
            $table->string('current_club_name')->nullable();
            $table->unsignedBigInteger('market_value_in_eur')->nullable();
            $table->unsignedBigInteger('highest_market_value_in_eur')->nullable();
            $table->timestamps();
        });

        Schema::create('clubs', function (Blueprint $table) {
            $table->unsignedBigInteger('club_id')->primary();
            $table->string('club_code')->nullable();
            $table->string('name')->index();
            $table->string('logo')->nullable();
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
    }

    public function down(): void
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('clubs');
    }
};

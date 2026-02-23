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
        // Drop existing table if it exists
        Schema::dropIfExists('players');

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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
        
        // Restore original basic schema if needed, but since we are replacing it, 
        // usually down() in this context would just drop it.
    }
};

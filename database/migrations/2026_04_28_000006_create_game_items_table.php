<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_items', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->index();
            $table->string('name_en')->index();
            $table->string('name_ar')->nullable()->index();
            $table->string('country', 100)->nullable();
            $table->string('external_id', 100)->nullable()->index();
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Compound index for optimized autocomplete
            $table->index(['type', 'name_en']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_items');
    }
};

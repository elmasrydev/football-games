<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('players');
        Schema::dropIfExists('clubs');
    }

    public function down(): void
    {
        // No easy rollback for dropped tables with 34k records
    }
};

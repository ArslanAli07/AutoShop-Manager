<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the old Laravel default jobs table to avoid conflicts
        Schema::dropIfExists('jobs');
    }

    public function down(): void
    {
        // Restore if needed (though we'll recreate with proper schema in next migration)
    }
};

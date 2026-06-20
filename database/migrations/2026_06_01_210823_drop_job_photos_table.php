<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop the job_photos table — it was created speculatively but
     * no model, controller, view, or route was ever built for it.
     */
    public function up(): void
    {
        Schema::dropIfExists('job_photos');
    }

    /**
     * Re-create the table on rollback so the migration is reversible.
     */
    public function down(): void
    {
        Schema::create('job_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->string('file_path', 255);
            $table->string('caption', 100)->nullable();
            $table->timestamps();

            $table->index(['job_id']);
        });
    }
};

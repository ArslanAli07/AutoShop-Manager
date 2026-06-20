<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('service_preset_id')->nullable()->constrained('service_presets')->nullOnDelete();
            $table->string('description', 255)->nullable();
            $table->decimal('labor_cost', 10, 2)->default(0);
            $table->timestamps();

            $table->index(['job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_services');
    }
};

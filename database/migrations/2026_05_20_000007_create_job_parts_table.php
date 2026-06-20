<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parts_reference_id')->nullable()->constrained('parts_reference')->nullOnDelete();
            $table->string('part_name', 100)->nullable();
            $table->string('part_number', 50)->nullable();
            $table->decimal('quantity', 8, 2)->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2)->storedAs('quantity * unit_price');
            $table->timestamps();

            $table->index(['job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_parts');
    }
};

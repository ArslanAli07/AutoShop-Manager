<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->string('plate_number', 20);
            $table->string('make', 50);
            $table->string('model', 50);
            $table->year('year')->nullable();
            $table->string('color', 30)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['plate_number']);
            $table->index(['customer_id', 'make', 'model']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts_reference', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('part_number', 50)->nullable();
            $table->decimal('default_price', 10, 2)->default(0);
            $table->boolean('needs_reorder')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts_reference');
    }
};

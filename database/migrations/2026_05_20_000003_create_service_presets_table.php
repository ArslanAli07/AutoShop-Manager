<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_presets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('name_urdu', 100)->nullable();
            $table->string('category', 50);
            $table->decimal('default_labor_cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_presets');
    }
};

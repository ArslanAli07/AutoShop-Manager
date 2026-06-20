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
        Schema::table('customers', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('cars', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('jobs', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('parts_reference', function (Blueprint $table) {
            $table->softDeletes();
        });
        
        Schema::table('service_presets', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('cars', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('jobs', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('parts_reference', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        
        Schema::table('service_presets', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};

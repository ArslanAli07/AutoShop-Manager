<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number', 20)->unique();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('car_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['received', 'in_progress', 'ready', 'delivered', 'cancelled'])->default('received');
            $table->enum('payment_status', ['paid', 'unpaid', 'partial'])->default('unpaid');
            $table->decimal('amount_paid', 10, 2)->default(0);
            $table->unsignedInteger('mileage_in')->nullable();
            $table->unsignedInteger('mileage_out')->nullable();
            $table->date('date_in');
            $table->date('date_out')->nullable();
            $table->text('notes')->nullable();
            $table->text('warranty_notes')->nullable();
            $table->date('next_service_date')->nullable();
            $table->unsignedInteger('next_service_mileage')->nullable();
            $table->timestamps();

            $table->index(['status', 'payment_status', 'date_in']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

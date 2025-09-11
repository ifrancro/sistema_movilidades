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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number')->unique();
            $table->string('chassis_number')->unique();
            $table->string('brand');
            $table->string('model');
            $table->integer('year');
            $table->string('color');
            $table->integer('capacity');
            $table->enum('vehicle_type', ['micro', 'provincial_fleet', 'departmental_fleet'])->default('micro');
            $table->enum('status', ['active', 'maintenance', 'decommissioned'])->default('active');
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->onDelete('set null');
            // $table->foreignId('route_id')->nullable()->constrained('routes')->onDelete('set null'); // Se agregará después
            $table->date('registration_date');
            $table->date('insurance_expiry')->nullable();
            $table->date('technical_inspection_expiry')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};

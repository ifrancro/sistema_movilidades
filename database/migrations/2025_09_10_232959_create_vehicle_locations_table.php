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
        Schema::create('vehicle_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->decimal('speed_kmh', 5, 2)->nullable(); // Velocidad en km/h
            $table->decimal('heading', 5, 2)->nullable(); // Dirección en grados
            $table->timestamp('location_timestamp'); // Timestamp de la ubicación GPS
            $table->enum('status', ['moving', 'stopped', 'parked', 'offline'])->default('moving');
            $table->foreignId('route_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('stop_id')->nullable()->constrained()->onDelete('set null'); // Parada más cercana
            $table->decimal('distance_from_route_m', 8, 2)->nullable(); // Distancia de la ruta en metros
            $table->text('raw_gps_data')->nullable(); // Datos GPS raw para debugging
            $table->timestamps();
            
            // Índices para consultas rápidas
            $table->index(['vehicle_id', 'location_timestamp']);
            $table->index('location_timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_locations');
    }
};

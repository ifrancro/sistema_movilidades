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
        Schema::create('trip_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->string('trip_code')->unique(); // Código único del viaje
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->foreignId('start_stop_id')->nullable()->constrained('stops')->onDelete('set null');
            $table->foreignId('end_stop_id')->nullable()->constrained('stops')->onDelete('set null');
            $table->decimal('start_latitude', 10, 8)->nullable();
            $table->decimal('start_longitude', 11, 8)->nullable();
            $table->decimal('end_latitude', 10, 8)->nullable();
            $table->decimal('end_longitude', 11, 8)->nullable();
            $table->integer('duration_minutes')->nullable(); // Duración total del viaje
            $table->decimal('distance_km', 8, 2)->nullable(); // Distancia total recorrida
            $table->integer('passenger_count')->nullable(); // Número de pasajeros
            $table->decimal('average_speed_kmh', 5, 2)->nullable(); // Velocidad promedio
            $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled'])->default('scheduled');
            $table->enum('direction', ['outbound', 'inbound'])->default('outbound');
            $table->json('stops_visited')->nullable(); // Paradas visitadas con timestamps
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Índices para consultas rápidas
            $table->index(['vehicle_id', 'start_time']);
            $table->index(['route_id', 'start_time']);
            $table->index(['driver_id', 'start_time']);
            $table->index('start_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_history');
    }
};

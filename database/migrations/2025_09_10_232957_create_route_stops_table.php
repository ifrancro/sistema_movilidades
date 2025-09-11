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
        Schema::create('route_stops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id')->constrained()->onDelete('cascade');
            $table->foreignId('stop_id')->constrained()->onDelete('cascade');
            $table->integer('sequence_order'); // Orden de la parada en la ruta
            $table->integer('estimated_time_minutes')->nullable(); // Tiempo estimado desde el inicio
            $table->decimal('distance_from_start_km', 8, 2)->nullable(); // Distancia desde el inicio
            $table->enum('direction', ['outbound', 'inbound'])->default('outbound'); // Dirección de la ruta
            $table->timestamps();
            
            // Índices únicos para evitar duplicados
            $table->unique(['route_id', 'stop_id', 'direction']);
            $table->unique(['route_id', 'sequence_order', 'direction']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('route_stops');
    }
};

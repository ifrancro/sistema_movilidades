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
        // Índices adicionales para optimización de consultas
        
        // Tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->index(['role', 'status']);
            $table->index('email');
        });
        
        // Tabla owners
        Schema::table('owners', function (Blueprint $table) {
            $table->index(['owner_type', 'status']);
            $table->index('registration_date');
        });
        
        // Tabla drivers
        Schema::table('drivers', function (Blueprint $table) {
            $table->index(['status', 'license_expiry']);
            $table->index('license_number');
        });
        
        // Tabla vehicles
        Schema::table('vehicles', function (Blueprint $table) {
            $table->index(['vehicle_type', 'status']);
            $table->index(['owner_id', 'status']);
            $table->index('plate_number');
            $table->index('chassis_number');
        });
        
        // Tabla routes
        Schema::table('routes', function (Blueprint $table) {
            $table->index(['type', 'status']);
            $table->index('code');
        });
        
        // Tabla stops
        Schema::table('stops', function (Blueprint $table) {
            $table->index(['type', 'status']);
            $table->index('code');
            // Índice espacial para consultas geográficas
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir índices adicionales
        
        // Tabla users
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role', 'status']);
            $table->dropIndex(['email']);
        });
        
        // Tabla owners
        Schema::table('owners', function (Blueprint $table) {
            $table->dropIndex(['owner_type', 'status']);
            $table->dropIndex(['registration_date']);
        });
        
        // Tabla drivers
        Schema::table('drivers', function (Blueprint $table) {
            $table->dropIndex(['status', 'license_expiry']);
            $table->dropIndex(['license_number']);
        });
        
        // Tabla vehicles
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropIndex(['vehicle_type', 'status']);
            $table->dropIndex(['owner_id', 'status']);
            $table->dropIndex(['plate_number']);
            $table->dropIndex(['chassis_number']);
        });
        
        // Tabla routes
        Schema::table('routes', function (Blueprint $table) {
            $table->dropIndex(['type', 'status']);
            $table->dropIndex(['code']);
        });
        
        // Tabla stops
        Schema::table('stops', function (Blueprint $table) {
            $table->dropIndex(['type', 'status']);
            $table->dropIndex(['code']);
            $table->dropIndex(['latitude', 'longitude']);
        });
    }
};

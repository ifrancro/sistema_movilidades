<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('alerts')->insert([
            [
                'title' => 'Vencimiento de Seguro Próximo',
                'description' => 'El seguro del vehículo ABC-123 vence en 30 días',
                'type' => 'insurance_expiry',
                'priority' => 'medium',
                'status' => 'pending',
                'vehicle_id' => 1,
                'driver_id' => 1,
                'route_id' => null,
                'created_by' => 1, // Admin
                'assigned_to' => 2, // Inspector
                'metadata' => json_encode(['expiry_date' => '2025-03-15', 'days_remaining' => 30]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Desviación de Ruta Detectada',
                'description' => 'El vehículo DEF-456 se desvió de su ruta asignada',
                'type' => 'route_deviation',
                'priority' => 'high',
                'status' => 'acknowledged',
                'vehicle_id' => 2,
                'driver_id' => 2,
                'route_id' => 2,
                'created_by' => 2, // Inspector
                'assigned_to' => 1, // Admin
                'metadata' => json_encode(['deviation_distance' => '2.5 km', 'expected_route' => 'SC-LP']),
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(1),
            ],
            [
                'title' => 'Licencia de Conductor por Vencer',
                'description' => 'La licencia del conductor María González vence en 15 días',
                'type' => 'license_expiry',
                'priority' => 'high',
                'status' => 'pending',
                'vehicle_id' => null,
                'driver_id' => 1,
                'route_id' => null,
                'created_by' => 1, // Admin
                'assigned_to' => 2, // Inspector
                'metadata' => json_encode(['license_number' => 'LIC001234', 'expiry_date' => '2025-12-31']),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
        ]);
    }
}

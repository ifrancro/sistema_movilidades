<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('vehicles')->insert([
            [
                'plate_number' => 'ABC-123',
                'chassis_number' => 'CHS001234567890',
                'brand' => 'Mercedes-Benz',
                'model' => 'OF-1724',
                'year' => 2020,
                'color' => 'Blanco',
                'capacity' => 45,
                'vehicle_type' => 'micro',
                'status' => 'active',
                'owner_id' => 1, // Juan Pérez
                'driver_id' => 1, // María González
                'registration_date' => '2020-03-15',
                'insurance_expiry' => '2025-03-15',
                'technical_inspection_expiry' => '2025-06-30',
                'notes' => 'Micro urbano en excelente estado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plate_number' => 'DEF-456',
                'chassis_number' => 'CHS002345678901',
                'brand' => 'Volvo',
                'model' => 'B270F',
                'year' => 2019,
                'color' => 'Azul',
                'capacity' => 50,
                'vehicle_type' => 'provincial_fleet',
                'status' => 'active',
                'owner_id' => 2, // Transporte Santa Cruz S.A.
                'driver_id' => 2, // Carlos Rodríguez
                'registration_date' => '2019-08-20',
                'insurance_expiry' => '2025-08-20',
                'technical_inspection_expiry' => '2025-09-15',
                'notes' => 'Bus interprovincial con aire acondicionado',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'plate_number' => 'GHI-789',
                'chassis_number' => 'CHS003456789012',
                'brand' => 'Scania',
                'model' => 'K360',
                'year' => 2021,
                'color' => 'Rojo',
                'capacity' => 55,
                'vehicle_type' => 'departmental_fleet',
                'status' => 'active',
                'owner_id' => 3, // Cooperativa de Transporte Unidos
                'driver_id' => null, // Sin conductor asignado
                'registration_date' => '2021-11-10',
                'insurance_expiry' => '2025-11-10',
                'technical_inspection_expiry' => '2025-12-31',
                'notes' => 'Bus interdepartamental de lujo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

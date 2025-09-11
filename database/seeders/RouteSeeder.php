<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('routes')->insert([
            [
                'name' => 'Ruta 1 - Centro a Plan 3000',
                'code' => 'R001',
                'type' => 'urban',
                'start_point' => 'Plaza 24 de Septiembre',
                'end_point' => 'Plan 3000',
                'distance_km' => 12.5,
                'estimated_duration_minutes' => 45,
                'fare' => 2.50,
                'status' => 'active',
                'first_departure' => '05:30:00',
                'last_departure' => '22:00:00',
                'operating_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
                'description' => 'Ruta urbana que conecta el centro de Santa Cruz con Plan 3000',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Santa Cruz - La Paz',
                'code' => 'SC-LP',
                'type' => 'interdepartmental',
                'start_point' => 'Terminal Bimodal Santa Cruz',
                'end_point' => 'Terminal de Buses La Paz',
                'distance_km' => 520.0,
                'estimated_duration_minutes' => 480,
                'fare' => 80.00,
                'status' => 'active',
                'first_departure' => '06:00:00',
                'last_departure' => '20:00:00',
                'operating_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
                'description' => 'Ruta interdepartamental entre Santa Cruz y La Paz',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Santa Cruz - Montero',
                'code' => 'SC-MON',
                'type' => 'interprovincial',
                'start_point' => 'Terminal Bimodal Santa Cruz',
                'end_point' => 'Terminal Montero',
                'distance_km' => 50.0,
                'estimated_duration_minutes' => 60,
                'fare' => 8.00,
                'status' => 'active',
                'first_departure' => '05:00:00',
                'last_departure' => '21:00:00',
                'operating_days' => json_encode(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']),
                'description' => 'Ruta interprovincial entre Santa Cruz y Montero',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

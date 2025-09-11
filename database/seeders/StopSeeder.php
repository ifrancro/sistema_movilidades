<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('stops')->insert([
            [
                'name' => 'Plaza 24 de Septiembre',
                'code' => 'P24S',
                'latitude' => -17.7833,
                'longitude' => -63.1833,
                'address' => 'Plaza 24 de Septiembre, Santa Cruz',
                'type' => 'terminal',
                'status' => 'active',
                'description' => 'Terminal principal en el centro de Santa Cruz',
                'amenities' => json_encode(['shelter', 'bench', 'lighting', 'ticket_office']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plan 3000',
                'code' => 'P3000',
                'latitude' => -17.7500,
                'longitude' => -63.2000,
                'address' => 'Plan 3000, Santa Cruz',
                'type' => 'terminal',
                'status' => 'active',
                'description' => 'Terminal en Plan 3000',
                'amenities' => json_encode(['shelter', 'bench', 'lighting']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Terminal Bimodal Santa Cruz',
                'code' => 'TBSC',
                'latitude' => -17.8000,
                'longitude' => -63.1500,
                'address' => 'Terminal Bimodal, Santa Cruz',
                'type' => 'station',
                'status' => 'active',
                'description' => 'Terminal principal para rutas interprovinciales e interdepartamentales',
                'amenities' => json_encode(['shelter', 'bench', 'lighting', 'ticket_office', 'restaurant', 'parking']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Terminal Montero',
                'code' => 'TMON',
                'latitude' => -17.3333,
                'longitude' => -63.2500,
                'address' => 'Terminal de Buses, Montero',
                'type' => 'terminal',
                'status' => 'active',
                'description' => 'Terminal de buses en Montero',
                'amenities' => json_encode(['shelter', 'bench', 'lighting', 'ticket_office']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Terminal de Buses La Paz',
                'code' => 'TBLP',
                'latitude' => -16.5000,
                'longitude' => -68.1500,
                'address' => 'Terminal de Buses, La Paz',
                'type' => 'station',
                'status' => 'active',
                'description' => 'Terminal principal de buses en La Paz',
                'amenities' => json_encode(['shelter', 'bench', 'lighting', 'ticket_office', 'restaurant', 'parking', 'hotel']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

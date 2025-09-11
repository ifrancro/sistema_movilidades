<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('drivers')->insert([
            [
                'user_id' => 4, // María González
                'license_number' => 'LIC001234',
                'license_expiry' => '2025-12-31',
                'license_category' => 'B',
                'status' => 'active',
                'hire_date' => '2023-08-15',
                'salary' => 3500.00,
                'emergency_contact' => 'Pedro González - +591 7 87654321',
                'medical_certificate' => 'CERT001',
                'medical_expiry' => '2025-06-30',
                'notes' => 'Conductora experimentada en rutas urbanas',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 5, // Carlos Rodríguez
                'license_number' => 'LIC005678',
                'license_expiry' => '2026-03-15',
                'license_category' => 'C',
                'status' => 'active',
                'hire_date' => '2024-01-10',
                'salary' => 4200.00,
                'emergency_contact' => 'Ana Rodríguez - +591 7 76543210',
                'medical_certificate' => 'CERT002',
                'medical_expiry' => '2025-09-15',
                'notes' => 'Conductor especializado en rutas interprovinciales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

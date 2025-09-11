<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('owners')->insert([
            [
                'user_id' => 3, // Juan Pérez
                'encrypted_name' => encrypt('Juan Pérez'),
                'encrypted_ci_nit' => encrypt('12345678'),
                'encrypted_address' => encrypt('Av. Cañoto #123, Santa Cruz'),
                'encrypted_phone' => encrypt('+591 7 12345678'),
                'owner_type' => 'individual',
                'status' => 'active',
                'registration_date' => '2024-01-15',
                'notes' => 'Propietario de micros urbanos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1, // Admin como dueño de empresa
                'encrypted_name' => encrypt('Transporte Santa Cruz S.A.'),
                'encrypted_ci_nit' => encrypt('1234567890123'),
                'encrypted_address' => encrypt('Av. Roca y Coronado #456, Santa Cruz'),
                'encrypted_phone' => encrypt('+591 3 23456789'),
                'owner_type' => 'company',
                'status' => 'active',
                'registration_date' => '2023-06-10',
                'notes' => 'Empresa de transporte interprovincial',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Inspector como dueño de cooperativa
                'encrypted_name' => encrypt('Cooperativa de Transporte Unidos'),
                'encrypted_ci_nit' => encrypt('9876543210987'),
                'encrypted_address' => encrypt('Calle Sucre #789, Santa Cruz'),
                'encrypted_phone' => encrypt('+591 3 34567890'),
                'owner_type' => 'cooperative',
                'status' => 'active',
                'registration_date' => '2024-03-20',
                'notes' => 'Cooperativa de micros departamentales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

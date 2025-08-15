<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadospaisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estados = [
            ['estado_pais_id' => 1, 'nombre' => 'Aguascalientes', 'pais_id' => '1'],
            ['estado_pais_id' => 2, 'nombre' => 'Baja California', 'pais_id' => '1'],
            ['estado_pais_id' => 3, 'nombre' => 'Baja California Sur', 'pais_id' => '1'],
            ['estado_pais_id' => 4, 'nombre' => 'Campeche', 'pais_id' => '1'],
            ['estado_pais_id' => 5, 'nombre' => 'Chiapas', 'pais_id' => '1'],
            ['estado_pais_id' => 6, 'nombre' => 'Chihuahua', 'pais_id' => '1'],
            ['estado_pais_id' => 7, 'nombre' => 'Coahuila de Zaragoza', 'pais_id' => '1'],
            ['estado_pais_id' => 8, 'nombre' => 'Colima', 'pais_id' => '1'],
            ['estado_pais_id' => 9, 'nombre' => 'Durango', 'pais_id' => '1'],
            ['estado_pais_id' => 10, 'nombre' => 'Guanajuato', 'pais_id' => '1'],
            ['estado_pais_id' => 11, 'nombre' => 'Guerrero', 'pais_id' => '1'],
            ['estado_pais_id' => 12, 'nombre' => 'Hidalgo', 'pais_id' => '1'],
            ['estado_pais_id' => 13, 'nombre' => 'Jalisco', 'pais_id' => '1'],
            ['estado_pais_id' => 14, 'nombre' => 'México', 'pais_id' => '1'],
            ['estado_pais_id' => 15, 'nombre' => 'Michoacán de Ocampo', 'pais_id' => '1'],
            ['estado_pais_id' => 16, 'nombre' => 'Morelos', 'pais_id' => '1'],
            ['estado_pais_id' => 17, 'nombre' => 'Ciudad de México', 'pais_id' => '1'],
            ['estado_pais_id' => 18, 'nombre' => 'Nayarit', 'pais_id' => '1'],
            ['estado_pais_id' => 19, 'nombre' => 'Nuevo León', 'pais_id' => '1'],
            ['estado_pais_id' => 20, 'nombre' => 'Oaxaca', 'pais_id' => '1'],
            ['estado_pais_id' => 21, 'nombre' => 'Puebla', 'pais_id' => '1'],
            ['estado_pais_id' => 22, 'nombre' => 'Querétaro', 'pais_id' => '1'], // Corregido: Querétaro Arteaga a Querétaro
            ['estado_pais_id' => 23, 'nombre' => 'Quintana Roo', 'pais_id' => '1'],
            ['estado_pais_id' => 24, 'nombre' => 'San Luis Potosí', 'pais_id' => '1'],
            ['estado_pais_id' => 25, 'nombre' => 'Sinaloa', 'pais_id' => '1'],
            ['estado_pais_id' => 26, 'nombre' => 'Sonora', 'pais_id' => '1'],
            ['estado_pais_id' => 27, 'nombre' => 'Tabasco', 'pais_id' => '1'],
            ['estado_pais_id' => 28, 'nombre' => 'Tamaulipas', 'pais_id' => '1'],
            ['estado_pais_id' => 29, 'nombre' => 'Tlaxcala', 'pais_id' => '1'],
            ['estado_pais_id' => 30, 'nombre' => 'Veracruz de Ignacio de la Llave', 'pais_id' => '1'],
            ['estado_pais_id' => 31, 'nombre' => 'Yucatán', 'pais_id' => '1'],
            ['estado_pais_id' => 32, 'nombre' => 'Zacatecas', 'pais_id' => '1'],
        ];

        DB::table('estadospaises')->insert($estados);
    }
}
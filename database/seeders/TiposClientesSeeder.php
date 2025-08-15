<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Residencial', 'descripcion' => 'Cliente de tipo Residencial'],
            ['nombre' => 'Empresarial', 'descripcion' => 'Cliente de tipo Empresarial'],
            ['nombre' => 'Gobierno', 'descripcion' => 'Cliente de tipo gobierno'],
            ['nombre' => 'Otro', 'descripcion' => 'Cliente de tipo no categorizado'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tiposclientes')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

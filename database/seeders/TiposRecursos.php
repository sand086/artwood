<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposRecursos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Producto',
                'descripcion' => 'Recursos de productos.',
                'tabla_referencia' => 'productos',
            ],
            [
                'nombre' => 'Servicio',
                'descripcion' => 'Recursos de servicios.',
                'tabla_referencia' => 'servicios',
            ],
            [
                'nombre' => 'Material',
                'descripcion' => 'Recursos de materiales.',
                'tabla_referencia' => 'materiales',
            ],
            [
                'nombre' => 'Equipo',
                'descripcion' => 'Recursos de equipos.',
                'tabla_referencia' => 'equipos',
            ],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tiposrecursos')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'tabla_referencia' => $tipo['tabla_referencia'],
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ]);
        }
    }
}

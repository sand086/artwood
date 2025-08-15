<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposProyectos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            [
                'nombre' => 'Proyectos de Obra',
                'descripcion' => 'Proyectos de Obra'
            ],
            [
                'nombre' => 'Proyectos Mantenimiento Obra',
                'descripcion' => 'Proyectos Mantenimiento Obra.',
            ],
            [
                'nombre' => 'Proyectos Mantenimiento Mobiliario',
                'descripcion' => 'Proyectos Mantenimiento Mobiliario.',
            ],
            [
                'nombre' => 'Proyectos de Producto terminado / Mobiliario',
                'descripcion' => 'Proyectos de Producto terminado / Mobiliario.',
            ],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tiposproyectos')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ]);
        }
    }
}

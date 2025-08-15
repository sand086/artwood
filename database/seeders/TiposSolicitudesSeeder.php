<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposSolicitudesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Residencial', 'descripcion' => 'Solicitud de tipo Residencial'],
            ['nombre' => 'Empresarial', 'descripcion' => 'Solicitud de tipo Empresarial'],
            ['nombre' => 'Gobierno Directa', 'descripcion' => 'Solicitud de tipo gobierno de asignacion directa'],
            ['nombre' => 'Gobierno Licitacion', 'descripcion' => 'Solicitud de tipo gobierno de licitacion'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('tipossolicitudes')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

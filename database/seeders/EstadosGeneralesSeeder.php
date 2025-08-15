<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadosGeneralesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $estados = [
            ['nombre' => 'Pendiente', 'categoria' => 'SOLICITUD'],
            ['nombre' => 'Autorizada', 'categoria' => 'SOLICITUD'],
            ['nombre' => 'No Autorizada', 'categoria' => 'SOLICITUD'],
            ['nombre' => 'Cancelada', 'categoria' => 'SOLICITUD'],
            ['nombre' => 'Solicitada', 'categoria' => 'COTIZACION'],
            ['nombre' => 'Generada', 'categoria' => 'COTIZACION'],
            ['nombre' => 'Enviada', 'categoria' => 'COTIZACION'],
            ['nombre' => 'Aceptada', 'categoria' => 'COTIZACION'],
            ['nombre' => 'Rechazada', 'categoria' => 'COTIZACION'],
            ['nombre' => 'Pendiente', 'categoria' => 'PRESUPUESTO'],
            ['nombre' => 'Aceptado', 'categoria' => 'PRESUPUESTO'],
            ['nombre' => 'Rechazado', 'categoria' => 'PRESUPUESTO'],
            ['nombre' => 'Finalizado', 'categoria' => 'PRESUPUESTO'],
        ];

        foreach ($estados as $estado) {
            DB::table('estadosgenerales')->insert([
                'nombre' => $estado['nombre'],
                'categoria' => $estado['categoria'],
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

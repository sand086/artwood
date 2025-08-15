<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FuentesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Contacto Directo', 'descripcion' => 'Cliente que llega por contacto directo'],
            ['nombre' => 'Externo', 'descripcion' => 'Cliente que llega por persona externa a la empresa'],
            ['nombre' => 'Publicidad', 'descripcion' => 'Cliente que llega por publicidad'],
            ['nombre' => 'Referencia', 'descripcion' => 'Cliente que llega referenciado por otro cliente'],
            ['nombre' => 'Redes Sociales', 'descripcion' => 'Cliente que llega por redes sociales'],
            ['nombre' => 'Otros', 'descripcion' => 'Cliente que llega por fuente no determinada'],
        ];

        foreach ($tipos as $tipo) {
            DB::table('fuentes')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

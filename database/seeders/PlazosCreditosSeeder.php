<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlazosCreditosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plazos = [
            ['nombre' => '30 DIAS'],
            ['nombre' => '60 DIAS'],
            ['nombre' => '90 DIAS'],
        ];

        foreach ($plazos as $plazo) {
            DB::table('plazoscreditos')->insert([
                'nombre' => $plazo['nombre'],
                'estado' => 'A',
                'fecha_registro' => now(),
            ]);
        }
    }
}

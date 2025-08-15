<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiposIdentificaciones extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $tipos = [
            [
                'nombre' => 'Sin Identificación',
                'descripcion' => 'Sin identificación oficial. No se requiere o esta pendiente la identificación para el registro.'
            ],
            [
                'nombre' => 'Credencial para Votar INE',
                'descripcion' => 'Credencial para votar emitida por el Instituto Nacional Electoral. Principal identificación oficial para ciudadanos mexicanos mayores de 18 años.'
            ],
            [
                'nombre' => 'Pasaporte Mexicano',
                'descripcion' => 'Documento oficial expedido por la Secretaría de Relaciones Exteriores (SRE) para viajes internacionales y válido como identificación dentro de México.',
            ],
            [
                'nombre' => 'Cédula Profesional',
                'descripcion' => 'Documento expedido por la Dirección General de Profesiones de la SEP que acredita la formación profesional. Válida como identificación oficial.',
            ],
            [
                'nombre' => 'Licencia de Conducir',
                'descripcion' => 'Documento expedido por autoridades estatales o municipales que autoriza la conducción de vehículos. Aceptada frecuentemente como identificación.',
            ],
            [
                'nombre' => 'Cartilla del Servicio Militar Nacional',
                'descripcion' => 'Documento expedido por la SEDENA una vez liberado el Servicio Militar Nacional. Válido como identificación oficial para varones.',
            ],
            [
                'nombre' => 'Tarjeta de Residente (Temporal/Permanente)',
                'descripcion' => 'Documento expedido por el Instituto Nacional de Migración (INM) que acredita la estancia legal de extranjeros en México.',
            ],
            [
                 'nombre' => 'Acta de Nacimiento',
                 'descripcion' => 'Documento oficial que acredita el nacimiento de una persona. Usado principalmente para trámites específicos, no como ID fotográfica diaria.',
            ],
            [
                 'nombre' => 'CURP',
                 'descripcion' => 'Clave Única de Registro de Población. Código alfanumérico esencial, a menudo requerido junto con una ID con foto.',
            ]
        ];

        foreach ($tipos as $tipo) {
            DB::table('tiposidentificaciones')->insert([
                'nombre' => $tipo['nombre'],
                'descripcion' => $tipo['descripcion'],
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ]);
        }
    }
}

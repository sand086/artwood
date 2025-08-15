<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // DB::table('personas')->insert([
        //     'persona_id' => 1, // Usuario test
        //     'nombres' => 'Test',
        //     'apellidos' => 'Usuario',
        //     'direccion' => 'Calle Falsa 123',
        //     'telefono' => '555-1234',
        //     'correo_electronico' => 'test@correo.com',
        //     'estado' => 'A',
        //     'fecha_registro' => now(),
        //     'fecha_actualizacion' => now(),
        // ]);

        $personas = [
            [
                'persona_id' => 1, // Usuario Admin ASICOM
                'nombres' => 'Admin',
                'apellidos' => 'ASICOM',
                'direccion' => 'Calle Falsa 123',
                'telefono' => '555-1234',
                'correo_electronico' => 'admin@asicom.com',
                'tipo_identificacion_id' => 1,
                'identificador' => '123456789',
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'persona_id' => 2, // Usuario test
                'nombres' => 'Test',
                'apellidos' => 'Usuario',
                'direccion' => 'Calle Falsa 123',
                'telefono' => '555-1234',
                'correo_electronico' => 'test@correo.com',
                'tipo_identificacion_id' => 1,
                'identificador' => '987654321',
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'persona_id' => 3, // Usuario Lina Sanchez
                'nombres' => 'Lina',
                'apellidos' => 'Sanchez',
                'direccion' => 'Colombia Cali',
                'telefono' => '5519352240',
                'correo_electronico' => 'calidad@asicomsystems.com.mx',
                'tipo_identificacion_id' => 1,
                'identificador' => '987654321',
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'persona_id' => 4, // Usuario Berenice Artwood
                'nombres' => 'Berenice',
                'apellidos' => 'Artwood',
                'direccion' => 'Carretera Mexico-Cuernavaca 447 Col. San Pedro Mártir, C.P. 14650, CDMX',
                'telefono' => '5533404418',
                'correo_electronico' => 'test@asicomsystems.com.mx',
                'tipo_identificacion_id' => 1,
                'identificador' => '987654321',
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ],
            [
                'persona_id' => 5, // Usuario Hector Artwood
                'nombres' => 'Hector',
                'apellidos' => 'Artwood',
                'direccion' => 'Carretera Mexico-Cuernavaca 447 Col. San Pedro Mártir, C.P. 14650, CDMX.',
                'telefono' => '5533404418',
                'correo_electronico' => 'test2@asicomsystems.com.mx',
                'tipo_identificacion_id' => 1,
                'identificador' => '987654321',
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ],
            // Agrega más registros aquí...
        ];

        DB::table('personas')->insert($personas);
    }
}

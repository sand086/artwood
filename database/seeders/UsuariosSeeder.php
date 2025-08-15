<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        // DB::table('usuarios')->insert([
        //     'nombre' => 'test',
        //     'contrasena' => Hash::make('password123'),
        //     'fecha_ultimo_acceso' => null,
        //     'metodo_doble_factor' => 'app',
        //     'doble_factor' => null,
        //     'no_intentos' => 0,
        //     'role_id' => 1,  //Root
        //     'persona_id' => 1, // tesst ususairo
        //     'IP' => '127.0.0.1',
        //     'estado' => 'A',
        // ]);

        $usuarios = [
            [
                'nombre' => 'admin-asicom',
                'contrasena' => Hash::make('4s1c0m4dm1n-AW'),
                'fecha_ultimo_acceso' => null,
                'metodo_doble_factor' => 'app',
                'doble_factor' => 'F3CZ46WF27N774DN',
                'no_intentos' => 0,
                'role_id' => 1,
                'persona_id' => 1,
                'IP' => '127.0.0.1',
                'estado' => 'A',
            ],
            [
                'nombre' => 'test',
                'contrasena' => Hash::make('password123'),
                'fecha_ultimo_acceso' => null,
                'metodo_doble_factor' => 'app',
                'doble_factor' => null,
                'no_intentos' => 0,
                'role_id' => 1,
                'persona_id' => 2,
                'IP' => '127.0.0.1',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Lina',
                'contrasena' => '$2y$12$iZ0wKOpP17rpwoT5uLRIV.meZ6Ge7okuloDGqNgz52fdxSm3aH9ju',
                'fecha_ultimo_acceso' => '2025-05-08 15:38:39',
                'metodo_doble_factor' => 'app',
                'doble_factor' => 'RFMYPL5KQ4FITKFF',
                'no_intentos' => 0,
                'role_id' => 1,
                'persona_id' => 3,
                'IP' => '127.0.0.1',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Bere',
                'contrasena' => '$2y$12$iZ0wKOpP17rpwoT5uLRIV.meZ6Ge7okuloDGqNgz52fdxSm3aH9ju',
                'fecha_ultimo_acceso' => '2025-05-13 16:00:16',
                'metodo_doble_factor' => 'app',
                'doble_factor' => 'ZOZHENGUCAO36ZVJ',
                'no_intentos' => 0,
                'role_id' => 1,
                'persona_id' => 4,
                'IP' => '127.0.0.1',
                'estado' => 'A',
            ],
            [
                'nombre' => 'Hector',
                'contrasena' => '$2y$12$I88fY4T6y4Zyi.SYkLHP2.Y1ARty6dJzXj5Hia/wAzat5IDl6k3sa',
                'fecha_ultimo_acceso' => null,
                'metodo_doble_factor' => 'app',
                'doble_factor' => null,
                'no_intentos' => 0,
                'role_id' => 1,
                'persona_id' => 5,
                'IP' => '127.0.0.1',
                'estado' => 'A',
            ],
            // Agrega más registros aquí...
        ];

        DB::table('usuarios')->insert($usuarios);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModeloTieneRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleId = 1; // El role_id que quieres asignar
        $modelType = 'App\\Models\\Usuarios'; // El tipo de modelo

        $modelos = [];
        for ($i = 1; $i <= 5; $i++) {
            $modelos[] = [
                'role_id' => $roleId,
                'model_type' => $modelType,
                'model_id' => $i,
            ];
        }

        // Insertar los datos en la tabla modelo_tiene_roles
        DB::table('modelo_tiene_roles')->insert($modelos);
    }
}
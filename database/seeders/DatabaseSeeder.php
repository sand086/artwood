<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App; // Importar el facade App

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Seeders que deben ejecutarse en TODOS los entornos (datos base)
        $this->call([
            PermisosSeeder::class,
            TiposIdentificaciones::class,
            TiposRecursos::class,
            PersonasSeeder::class,
            UsuariosSeeder::class,
            ModeloTieneRolesSeeder::class,
            EstadosGeneralesSeeder::class,
            PlazosCreditosSeeder::class,
            TiposClientesSeeder::class,
            TiposSolicitudesSeeder::class,
            UnidadesMedidasSeeder::class,
            PaisesSeeder::class,
            EstadospaisesSeeder::class,
            MunicipiosSeeder::class,
            AreasSeeder::class,
            FuentesSeeder::class,
            TiposProyectos::class, // Parece ser un dato base, añádelo si es el caso
            ClientesSeeder::class,
            ProveedoresSeeder::class,
        ]);

        // Seeders que solo deben ejecutarse en entornos de desarrollo o pruebas
        // Estos son típicamente los que usan factories para generar datos masivos.
        if (App::environment(['local', 'development', 'testing'])) {
            $this->call([
                // Ejemplo: Si tienes un seeder para Clientes que usa un factory
                // Clientes::class, // Asegúrate que este es el seeder: Database\Seeders\Clientes
                // Ejemplo: Si tienes un seeder para TiposGastos que usa un factory
                // TiposGastos_::class, // Asegúrate que este es el seeder: Database\Seeders\TiposGastos_
                // Agrega aquí otros seeders que usen factories o sean solo para desarrollo/pruebas
            ]);

            // También se pueden ejecutar factories directamente aquí si es necesario para modelos específicos
            // Ejemplo:
            // \App\Models\OtroModeloParaPruebas::factory(50)->create();
            \App\Models\Personas::factory(45)->create();
            \App\Models\Productos::factory(20)->create();
            \App\Models\Servicios::factory(20)->create();
            // \App\Models\Clientes::factory(5)->create();
            // \App\Models\Proveedores::factory(10)->create();
            \App\Models\Materiales::factory(50)->create();
            \App\Models\Equipos::factory(50)->create();
            // \App\Models\TiposGastos::factory(5)->create();
        }
    }
}

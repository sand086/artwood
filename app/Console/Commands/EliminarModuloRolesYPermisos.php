<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class EliminarModuloRolesYPermisos extends Command
{
    protected $signature = 'modulo:eliminar-roles-permisos {--force}';
    protected $description = 'Elimina los archivos y configuraciones generadas para roles y permisos. Aquellos que no se puedan eliminar se dejan con su versión por defecto.';

    public function handle()
    {
        $force = $this->option('force');

        // Lista de archivos generados por el comando de generación
        $files = [
            // Controladores
            app_path("Http/Controllers/RolesController.php"),
            app_path("Http/Controllers/PermisosController.php"),
            // Requests
            app_path("Http/Requests/RolesRequest.php"),
            app_path("Http/Requests/PermisosRequest.php"),
            // Vistas
            resource_path("views/modules/Roles/index.blade.php"),
            resource_path("views/modules/Permisos/index.blade.php"),
            // Archivos JS
            resource_path("js/modules/Roles/index.js"),
            resource_path("js/modules/Permisos/index.js"),
            // Servicios
            app_path("Services/RolesService.php"),
            app_path("Services/PermisosService.php"),
            // Repositorios
            app_path("Repositories/RolesRepository.php"),
            app_path("Repositories/PermisosRepository.php"),
            // Tests
            base_path("tests/Feature/RolesTest.php"),
            base_path("tests/Feature/PermisosTest.php"),
            // Modelos
            app_path("Models/Roles.php"),
            app_path("Models/Permisos.php"),
            // Seeder
            database_path("seeders/PermisosSeeder.php"),
        ];

        foreach ($files as $file) {
            if (File::exists($file)) {
                if ($force || $this->confirm("¿Desea eliminar {$file}?", false)) {
                    File::delete($file);
                    $this->info("Eliminado: {$file}");
                } else {
                    $this->warn("Se dejó por defecto: {$file}");
                }
            } else {
                $this->info("No existe: {$file}");
            }
        }

        // Eliminar migraciones de spatie creadas (se asume que tienen en su nombre "crear_tablas_roles_permisos")
        $migrationFiles = File::glob(database_path("migrations/*_crear_tablas_roles_permisos.php"));
        foreach ($migrationFiles as $migrationFile) {
            if ($force || $this->confirm("¿Desea eliminar la migración {$migrationFile}?", false)) {
                File::delete($migrationFile);
                $this->info("Migración eliminada: {$migrationFile}");
            } else {
                $this->warn("Migración no eliminada: {$migrationFile}");
            }
        }

        // Restaurar rutas en routes/web.php (eliminar líneas insertadas por el comando)
        $routesPath = base_path("routes/web.php");
        if (File::exists($routesPath)) {
            $content = File::get($routesPath);
            // Se eliminan las líneas con los inserts de roles y permisos
            $content = preg_replace("/\n\s*use\s+App\\\\Http\\\\Controllers\\\\RolesController;/", "", $content);
            $content = preg_replace("/\n\s*Route::resource\('roles',\s*RolesController::class\);/", "", $content);
            $content = preg_replace("/\n\s*use\s+App\\\\Http\\\\Controllers\\\\PermisosController;/", "", $content);
            $content = preg_replace("/\n\s*Route::resource\('permisos',\s*PermisosController::class\);/", "", $content);
            File::put($routesPath, $content);
            $this->info("Rutas de roles y permisos eliminadas de routes/web.php");
        }

        // Opcional: eliminar directorios vacíos creados (solo si están completamente vacíos)
        $directories = [
            resource_path("views/modules/Roles"),
            resource_path("views/modules/Permisos"),
            resource_path("js/modules/Roles"),
            resource_path("js/modules/Permisos"),
        ];

        foreach ($directories as $dir) {
            if (File::exists($dir)) {
                // Si el directorio está vacío, se elimina
                if (empty(File::files($dir)) && empty(File::directories($dir))) {
                    File::deleteDirectory($dir);
                    $this->info("Directorio eliminado: {$dir}");
                } else {
                    $this->warn("El directorio {$dir} no está vacío, no se eliminó.");
                }
            }
        }

        $this->info("Proceso de eliminación completado.");
        return 0;
    }
}

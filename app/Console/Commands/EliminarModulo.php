<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EliminarModulo extends Command
{
    protected $signature = 'modulo:eliminar {nombre}';
    protected $description = 'Elimina un módulo completo, incluyendo controlador, modelo, form request, servicio, repositorio, vista y archivos JS';

    public function handle()
    {
        $nombre = $this->argument('nombre');

        // Eliminar Modelo y Migración
        $this->deleteModelAndMigration($nombre);

        // Eliminar Controlador
        $this->deleteFile(app_path("Http/Controllers/{$nombre}Controller.php"));

        // Eliminar ruta
        $this->deleteRoute($nombre);

        // Eliminar opcion de menu
        $this->deleteMenuOpction($nombre);

        // Eliminar Form Request
        $this->deleteFile(app_path("Http/Requests/{$nombre}Request.php"));

        // Eliminar Servicio
        $this->deleteFile(app_path("Services/{$nombre}Service.php"));

        // Eliminar Repositorio
        $this->deleteFile(app_path("Repositories/{$nombre}Repository.php"));

        // Eliminar Vista Blade
        $this->deleteDirectory(resource_path("views/modules/{$nombre}"));

        // Eliminar Archivos JS
        $this->deleteDirectory(resource_path("js/modules/{$nombre}"));

        $this->info("Módulo '{$nombre}' eliminado exitosamente.");
    }

    protected function deleteModelAndMigration($nombre)
    {
        // Eliminar Modelo
        $modelPath = app_path("Models/{$nombre}.php");
        if (File::exists($modelPath)) {
            File::delete($modelPath);
            $this->info("Archivo '{$modelPath}' eliminado.");
        } else {
            $this->warn("Archivo '{$modelPath}' no encontrado.");
        }

        // Eliminar Migración
        $migrationFiles = File::glob(database_path('migrations/*_create_' . strtolower($nombre) . '_table.php'));
        foreach ($migrationFiles as $migrationFile) {
            File::delete($migrationFile);
            $this->info("Archivo de migración '{$migrationFile}' eliminado.");
        }

        // Eliminar registros de migración en la base de datos
        $migrationFilesBasename = array_map(function ($file) {
            return basename($file);
        }, $migrationFiles);
        if (!empty($migrationFilesBasename)) {
            DB::table('migrations')->whereIn('migration', $migrationFilesBasename)->delete();
            $this->info("Registros de migración eliminados de la base de datos.");
        } else {
            $this->warn("No se encontraron registros de migración en la base de datos.");
        }
    }

    protected function deleteFile($path)
    {
        if (File::exists($path)) {
            File::delete($path);
            $this->info("Archivo '{$path}' eliminado.");
        } else {
            $this->warn("Archivo '{$path}' no encontrado.");
        }
    }

    protected function deleteDirectory($path)
    {
        if (File::exists($path)) {
            File::deleteDirectory($path);
            $this->info("Directorio '{$path}' eliminado.");
        } else {
            $this->warn("Directorio '{$path}' no encontrado.");
        }
    }

    protected function deleteRoute($nombreModulo)
    {
        $routePath = base_path('routes/web.php');
        $controllerName = "{$nombreModulo}Controller";
        $controllerUseStatement = "use App\Http\Controllers\\{$controllerName};";
        $routeDefinition = "Route::resource('" . Str::lower($nombreModulo) . "', {$controllerName}::class);";

        $routeContent = File::get($routePath);

        // Eliminar "use" del controlador
        $routeContent = str_replace($controllerUseStatement . "\n", '', $routeContent);

        // Eliminar definición de ruta
        $routeContent = str_replace($routeDefinition . "\n", '', $routeContent);

        File::put($routePath, $routeContent);
    }

    protected function deleteMenuOpction($nombreModulo)
    {
        $sidebarPath = resource_path('views/partials/sidebar.blade.php');
        $moduleNameMin = Str::lower($nombreModulo);
        $moduleNameDisplay = Str::title(str_replace('_', ' ', Str::snake($nombreModulo)));
        // $moduleNameDisplay = Str::pluralStudly($nombreModulo);

        $linkContent = "
            <li>
                <a href=\"{$moduleNameMin}\" class=\"flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100\">
                    <i data-lucide=\"{$moduleNameMin}\" class=\"w-6 h-6 flex-shrink-0 text-gray-600\"></i>
                    <span x-show=\"sidebarOpen\" x-transition:opacity>{$moduleNameDisplay}</span>
                </a>
            </li>
            ";

        $sidebarContent = File::get($sidebarPath);
        $sidebarContent = str_replace($linkContent, '', $sidebarContent);
        File::put($sidebarPath, $sidebarContent);
    }
}

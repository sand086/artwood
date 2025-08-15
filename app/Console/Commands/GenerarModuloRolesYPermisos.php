<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerarModuloRolesYPermisos extends Command
{
    // Sólo se mantienen las opciones --spatie y --force.
    protected $signature = 'modulo:generar-roles-permisos {--spatie} {--force}';
    protected $description = 'Genera un módulo para la administración de roles y permisos: crea controladores, requests, rutas, vistas, archivos JS, tests, servicios y repositorios para roles y permisos. Con --spatie se genera, además, la estructura para spatie/laravel-permission.';

    public function handle(): int
    {
        // Valores fijos según tu migración (actualizados a los nombres por defecto)
        $primaryKeyRole    = 'role_id';
        $primaryKeyPermiso = 'permission_id';
        // Para este ejemplo dejamos vacíos los campos, fillable y guarded
        $campos   = '';
        $fillable = 'nombre,guard_name,descripcion';
        $guarded  = '';
        $force    = $this->option('force');

        // Crear directorios necesarios
        $this->createDirectory(resource_path("views/modules/Roles"));
        $this->createDirectory(resource_path("views/modules/Permisos"));
        $this->createDirectory(resource_path("js/modules/Roles"));
        $this->createDirectory(resource_path("js/modules/Permisos"));
        $this->createDirectory(app_path("Services"));
        $this->createDirectory(app_path("Repositories"));
        $this->createDirectory(app_path("Http/Requests"));
        $this->createDirectory(base_path("tests/Feature"));
        $this->createDirectory(app_path("Models"));

        // Generar controladores (se espera que tus stubs sean personalizados)
        $this->createFileWithConfirmation(
            "RolesController.php",
            app_path("Http/Controllers/RolesController.php"),
            $this->getStub('roles.controller'),
            $force
        );
        $this->createFileWithConfirmation(
            "PermisosController.php",
            app_path("Http/Controllers/PermisosController.php"),
            $this->getStub('permisos.controller'),
            $force
        );

        // Generar Requests
        $this->generateRequestFile('Roles', $primaryKeyRole, $campos, app_path("Http/Requests/RolesRequest.php"), $force);
        $this->generateRequestFile('Permisos', $primaryKeyPermiso, $campos, app_path("Http/Requests/PermisosRequest.php"), $force);

        // Generar rutas
        $this->createRolesRoute();
        $this->createPermisosRoute();

        // Generar vistas
        $this->createFileWithConfirmation(
            "Roles/index.blade.php",
            resource_path("views/modules/Roles/index.blade.php"),
            $this->getStub('index.blade'),
            $force
        );
        $this->createFileWithConfirmation(
            "Permisos/index.blade.php",
            resource_path("views/modules/Permisos/index.blade.php"),
            $this->getStub('index.blade'),
            $force
        );

        // Generar archivos JS (stubs genéricos)
        $rolesJsStub = $this->getStub('index.js');
        $rolesJsStub = str_replace('{{primaryKey}}', $primaryKeyRole, $rolesJsStub);
        // Reemplaza {{formFields}} por un arreglo literal con los campos asignables
        $rolesJsStub = str_replace('{{formFields}}', "['nombre', 'guard_name', 'descripcion']", $rolesJsStub);
        $rolesJsStub = str_replace('{{NombreModulo}}', 'Roles', $rolesJsStub);
        $rolesJsStub = str_replace('{{nombreModulo}}', 'roles', $rolesJsStub);
        // Reemplaza {{dataTableColumns}} por la configuración completa de las columnas
        $rolesJsStub = str_replace('{{dataTableColumns}}', "[
            { data: 'role_id', name: 'role_id', title: 'ID' },
            { data: 'nombre', name: 'nombre', title: 'Nombre' },
            { data: 'guard_name', name: 'guard_name', title: 'Guard Name' },
            { data: 'descripcion', name: 'descripcion', title: 'Descripción' },
            {
                data: 'estado',
                name: 'estado',
                title: 'Estado',
                render: 'renderEstado',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                title: 'Acciones',
                orderable: false,
                searchable: false
            }
        ]", $rolesJsStub);
        $this->createFileWithConfirmation("roles/indexjs", resource_path("js/modules/Roles/index.js"), $rolesJsStub, $force);

        $permisosJsStub = $this->getStub('index.js');
        $permisosJsStub = str_replace('{{primaryKey}}', $primaryKeyPermiso, $permisosJsStub);
        $permisosJsStub = str_replace('{{formFields}}', $fillable ? "'" . implode("', '", explode(',', $fillable)) . "'" : '[]', $permisosJsStub);
        $permisosJsStub = str_replace('{{NombreModulo}}', 'Permisos', $permisosJsStub);
        $permisosJsStub = str_replace('{{nombreModulo}}', 'permisos', $permisosJsStub);
        $permisosJsStub = str_replace('{{dataTableColumns}}', '', $permisosJsStub);
        $this->createFileWithConfirmation("permisos/indexjs", resource_path("js/modules/Permisos/index.js"), $permisosJsStub, $force);

        // Generar Service y Repository para Roles
        $rolesServiceStub = $this->getStub('service');
        $rolesServiceStub = str_replace('{{NombreModulo}}', 'Roles', $rolesServiceStub);
        $rolesServiceStub = str_replace('{{nombreModulo}}', 'roles', $rolesServiceStub);
        $this->createFileWithConfirmation("RolesService.php", app_path("Services/RolesService.php"), $rolesServiceStub, $force);

        $rolesRepositoryStub = $this->getStub('repository');
        $rolesRepositoryStub = str_replace('{{NombreModulo}}', 'Roles', $rolesRepositoryStub);
        $rolesRepositoryStub = str_replace('{{nombreModulo}}', 'roles', $rolesRepositoryStub);
        $rolesRepositoryStub = str_replace('{{primaryKey}}', $primaryKeyRole, $rolesRepositoryStub);
        $rolesRepositoryStub = str_replace('{{camposSelect}}', $fillable ? "'" . implode("', '", explode(',', $fillable)) . "'" : '', $rolesRepositoryStub);
        $this->createFileWithConfirmation("RolesRepository.php", app_path("Repositories/RolesRepository.php"), $rolesRepositoryStub, $force);

        // Generar Service y Repository para Permisos
        $permisosServiceStub = $this->getStub('service');
        $permisosServiceStub = str_replace('{{NombreModulo}}', 'Permisos', $permisosServiceStub);
        $permisosServiceStub = str_replace('{{nombreModulo}}', 'permisos', $permisosServiceStub);
        $this->createFileWithConfirmation("PermisosService.php", app_path("Services/PermisosService.php"), $permisosServiceStub, $force);

        $permisosRepositoryStub = $this->getStub('repository');
        $permisosRepositoryStub = str_replace('{{NombreModulo}}', 'Permisos', $permisosRepositoryStub);
        $permisosRepositoryStub = str_replace('{{nombreModulo}}', 'permisos', $permisosRepositoryStub);
        $permisosRepositoryStub = str_replace('{{primaryKey}}', $primaryKeyPermiso, $permisosRepositoryStub);
        $permisosRepositoryStub = str_replace('{{camposSelect}}', $fillable ? "'" . implode("', '", explode(',', $fillable)) . "'" : '', $permisosRepositoryStub);
        $this->createFileWithConfirmation("PermisosRepository.php", app_path("Repositories/PermisosRepository.php"), $permisosRepositoryStub, $force);

        // Generar tests (stubs genéricos)
        $this->createFileWithConfirmation("RolesTest.php", base_path("tests/Feature/RolesTest.php"), $this->getStub('roles.test'), $force);
        $this->createFileWithConfirmation("PermisosTest.php", base_path("tests/Feature/PermisosTest.php"), $this->getStub('permisos.test'), $force);

        // Generar modelos usando el stub genérico (el stub incluye las constantes de fechas)
        $this->generateModelFile('Roles', 'roles', $primaryKeyRole, $force);
        $this->generateModelFile('Permisos', 'permisos', $primaryKeyPermiso, $force);

        // Si se activa --spatie, adaptar los modelos generados y generar la estructura adicional
        if ($this->option('spatie')) {
            $this->info("Adaptando modelos Roles y Permisos para Spatie...");
            $this->adaptSpatieModels();
            $this->info("Generando la estructura para spatie/laravel-permission...");
            $this->createPermissionConfig();
            $this->createSpatieMigration();
            $this->createPermissionSeeder();
        }

        $this->info("Módulo de Roles y Permisos generado exitosamente.");
        return 0;
    }

    /**
     * Adapta los modelos Roles y Permisos para trabajar con Spatie.
     * – En el modelo Roles se inyecta el "use" para BelongsToMany (si no existe),
     * Si algún modelo no existe, se pregunta si se desea crearlo. si no tiene force
     */
    protected function adaptSpatieModels(): void
    {
        // Adaptar modelo Roles
        $roleModelPath = app_path("Models/Roles.php");
        if (File::exists($roleModelPath)) {
            $content = File::get($roleModelPath);
            // Agregar "use" para BelongsToMany si no existe
            if (strpos($content, 'use Illuminate\Database\Eloquent\Relations\BelongsToMany;') === false) {
                $pattern = '/^(namespace\s+.*?;)/m';
                if (preg_match($pattern, $content, $matches)) {
                    $namespaceDeclaration = $matches[0];
                    $insertion = $namespaceDeclaration . "\n\nuse Illuminate\Database\Eloquent\Relations\BelongsToMany;";
                    $content = preg_replace($pattern, $insertion, $content, 1);
                }
            }
            // Cambiar extensión a Spatie Role
            $content = str_replace("extends Model", "extends \\Spatie\\Permission\\Models\\Role", $content);
            // Forzar clave primaria a 'role_id'
            $content = preg_replace("/protected\s+\$primaryKey\s*=\s*'[^']*';/", "protected \$primaryKey = 'role_id';", $content);
            // Agregar método permissions() con firma completa si no existe
            if (strpos($content, 'function permissions(') === false) {
                $permissionsMethod = <<<EOT

    /**
     * Relación de permisos personalizada para Spatie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return \$this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            'role_id',       // Clave foránea en la tabla pivot para este modelo (roles)
            'permission_id', // Clave foránea para el modelo relacionado (permissions)
            'role_id',       // Clave local en el modelo Roles
            'permission_id'  // Clave local en el modelo Permissions
        );
    }
EOT;
                $pos = strrpos($content, "}");
                if ($pos !== false) {
                    $content = substr_replace($content, $permissionsMethod . "\n", $pos, 0);
                }
            }
            File::put($roleModelPath, $content);
            $this->info("Modelo Roles adaptado para Spatie en {$roleModelPath}");
        } else {
            if ($this->confirm("El modelo Roles no existe. ¿Desea crearlo?", true)) {
                $this->generateModelFile('Roles', 'roles', 'role_id', true);
                $this->info("Modelo Roles creado.");
                $this->adaptSpatieModels();
            } else {
                $this->warn("No se creó el modelo Roles. No se aplicarán adaptaciones para Spatie.");
            }
        }

        // Adaptar modelo Permisos
        $permModelPath = app_path("Models/Permisos.php");
        if (File::exists($permModelPath)) {
            $content = File::get($permModelPath);
            // Agregar "use" para BelongsToMany si no existe (opcional)
            if (strpos($content, 'use Illuminate\Database\Eloquent\Relations\BelongsToMany;') === false) {
                $pattern = '/^(namespace\s+.*?;)/m';
                if (preg_match($pattern, $content, $matches)) {
                    $namespaceDeclaration = $matches[0];
                    $insertion = $namespaceDeclaration . "\n\nuse Illuminate\Database\Eloquent\Relations\BelongsToMany;";
                    $content = preg_replace($pattern, $insertion, $content, 1);
                }
            }
            // Cambiar extensión a Spatie Permission
            $content = str_replace("extends Model", "extends \\Spatie\\Permission\\Models\\Permission", $content);
            // Forzar clave primaria a 'permission_id'
            $content = preg_replace("/protected\s+\$primaryKey\s*=\s*'[^']*';/", "protected \$primaryKey = 'permission_id';", $content);
            // No se agrega método roles() para evitar conflicto.
            File::put($permModelPath, $content);
            $this->info("Modelo Permisos adaptado para Spatie en {$permModelPath}");
        } else {
            if ($this->confirm("El modelo Permisos no existe. ¿Desea crearlo?", true)) {
                $this->generateModelFile('Permisos', 'permisos', 'permission_id', true);
                $this->info("Modelo Permisos creado.");
                $this->adaptSpatieModels();
            } else {
                $this->warn("No se creó el modelo Permisos. No se aplicarán adaptaciones para Spatie.");
            }
        }
    }

    /**
     * Genera el archivo del modelo usando el stub genérico.
     */
    protected function generateModelFile(string $modelName, string $tableName, string $primaryKey, bool $force = false): void
    {
        $stub = $this->getStub('model');
        $contenido = str_replace('{{NombreModulo}}', $modelName, $stub);
        $contenido = str_replace('{{nombreModulo}}', $tableName, $contenido);
        $contenido = str_replace('{{primaryKey}}', $primaryKey, $contenido);
        $destino = app_path("Models/{$modelName}.php");
        $this->createFileWithConfirmation("{$modelName}.php", $destino, $contenido, $force);
    }

    /**
     * Genera el archivo Request usando el stub correspondiente.
     */
    protected function generateRequestFile(string $nombreModulo, string $primaryKey, ?string $campos, string $destino, bool $force = false): void
    {
        $stub = $this->getStub('request_');
        $nombreRequest = strtolower($nombreModulo) === 'roles' ? 'RolesRequest' : 'PermisosRequest';
        $rules = '';
        $messages = '';

        if ($campos) {
            $camposArray = explode(',', $campos);
            foreach ($camposArray as $campo) {
                $nombreCampo = explode(':', $campo)[0];
                if ($nombreCampo !== $primaryKey) {
                    $rules .= "'{$nombreCampo}' => 'required',\n            ";
                    $messages .= "'{$nombreCampo}.required' => 'El campo {$nombreCampo} es obligatorio.',\n            ";
                }
            }
        }
        $contenido = str_replace('{{NombreRequest}}', $nombreRequest, $stub);
        $contenido = str_replace('{{rules}}', trim($rules), $contenido);
        $contenido = str_replace('{{messages}}', trim($messages), $contenido);
        $this->createFileWithConfirmation("{$nombreRequest}.php", $destino, $contenido, $force);
    }

    // =================== Funciones de apoyo ===================

    protected function getStub(string $tipo): string
    {
        $ruta = __DIR__ . "/stubs/{$tipo}.stub";
        if (!File::exists($ruta)) {
            $this->error("El stub {$tipo}.stub no existe en " . __DIR__ . "/stubs/");
            exit(1);
        }
        return file_get_contents($ruta);
    }

    protected function createDirectory(string $ruta): void
    {
        if (!File::exists($ruta)) {
            File::makeDirectory($ruta, 0755, true);
            $this->info("Directorio creado: {$ruta}");
        }
    }

    protected function createFileWithConfirmation(string $archivo, string $ruta, string $contenido, bool $force = false): void
    {
        if (File::exists($ruta) && !$force) {
            if (!$this->confirm("El archivo {$archivo} ya existe. ¿Desea sobrescribirlo?", false)) {
                $this->warn("Se omitió {$archivo}");
                return;
            }
        }
        File::put($ruta, $contenido);
        $this->info("Archivo creado/actualizado: {$ruta}");
    }

    // =================== Generación de Rutas ===================

    protected function createRolesRoute(): void
    {
        $rutaArchivo = base_path('routes/web.php');
        $usoControlador = "use App\\Http\\Controllers\\RolesController;";
        $definicionRuta = "Route::resource('roles', RolesController::class);";
        $contenido = File::get($rutaArchivo);
        if (strpos($contenido, $usoControlador) === false) {
            $ultimaPosicionUse = strrpos($contenido, 'use ');
            if ($ultimaPosicionUse !== false) {
                $posSemicolon = strpos($contenido, ';', $ultimaPosicionUse) + 1;
                $contenido = substr_replace($contenido, "\n" . $usoControlador, $posSemicolon, 0);
            }
        }
        if (strpos($contenido, $definicionRuta) === false) {
            $contenido .= "\n" . $definicionRuta . "\n";
        }
        File::put($rutaArchivo, $contenido);
        $this->info("Ruta para roles agregada en web.php");
    }

    protected function createPermisosRoute(): void
    {
        $rutaArchivo = base_path('routes/web.php');
        $usoControlador = "use App\\Http\\Controllers\\PermisosController;";
        $definicionRuta = "Route::resource('permisos', PermisosController::class);";
        $contenido = File::get($rutaArchivo);
        if (strpos($contenido, $usoControlador) === false) {
            $ultimaPosicionUse = strrpos($contenido, 'use ');
            if ($ultimaPosicionUse !== false) {
                $posSemicolon = strpos($contenido, ';', $ultimaPosicionUse) + 1;
                $contenido = substr_replace($contenido, "\n" . $usoControlador, $posSemicolon, 0);
            }
        }
        if (strpos($contenido, $definicionRuta) === false) {
            $contenido .= "\n" . $definicionRuta . "\n";
        }
        File::put($rutaArchivo, $contenido);
        $this->info("Ruta para permisos agregada en web.php");
    }

    // =================== Funciones para spatie/laravel-permission ===================

    protected function createPermissionConfig(): void
    {
        $rutaConfig = config_path('permission.php');
        $nuevaConfiguracion = <<<PHP
<?php

return [
    'models' => [
        'permission' => App\\Models\\Permisos::class,
        'role' => App\\Models\\Roles::class,
    ],
    'table_names' => [
        'roles' => 'roles',
        'permissions' => 'permisos',
        'model_has_permissions' => 'modelo_tiene_permisos',
        'model_has_roles' => 'modelo_tiene_roles',
        'role_has_permissions' => 'rol_tiene_permisos',
    ],
    'column_names' => [
        'model_morph_key' => 'model_id',
    ],
    'cache' => [
        'expiration_time' => DateInterval::createFromDateString('24 hours'),
        'key' => 'spatie.permission.cache',
        'store' => 'default',
    ],
];
PHP;

        if (File::exists($rutaConfig)) {
            if ($this->confirm("El archivo config/permission.php ya existe. ¿Desea actualizar los parámetros necesarios?", false)) {
                $contenido = File::get($rutaConfig);
                // Actualizar parámetros de la sección 'models'
                $contenido = preg_replace(
                    "/('models'\s*=>\s*\[).*?(\n\s*\],)/s",
                    "'models' => [
                'permission' => App\\Models\\Permisos::class,
                'role' => App\\Models\\Roles::class,
            ],",
                    $contenido
                );
                // Actualizar parámetros de la sección 'table_names'
                $contenido = preg_replace(
                    "/('table_names'\s*=>\s*\[).*?(\n\s*\],)/s",
                    "'table_names' => [
                'roles' => 'roles',
                'permissions' => 'permisos',
                'model_has_permissions' => 'modelo_tiene_permisos',
                'model_has_roles' => 'modelo_tiene_roles',
                'role_has_permissions' => 'rol_tiene_permisos',
            ],",
                    $contenido
                );
                File::put($rutaConfig, $contenido);
                $this->info('Archivo config/permission.php actualizado correctamente.');
            } else {
                $this->warn('No se actualizó el archivo config/permission.php.');
            }
        } else {
            File::put($rutaConfig, $nuevaConfiguracion);
            $this->info('Archivo config/permission.php creado.');
        }
    }

    protected function createSpatieMigration(): void
    {
        $timestamp = now()->format('Y_m_d_His');
        $nombreArchivo = "001_01_01_{$timestamp}_crear_tablas_roles_permisos.php";
        $ruta = database_path("migrations/{$nombreArchivo}");
        $contenidoMigracion = <<<PHP
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permisos', function (Blueprint \$table) {
            \$table->id('permission_id');
            \$table->string('name')->comment('El nombre del permiso');
            \$table->string('guard_name')->comment('El guard name del permiso');
            // Campos adicionales
            \$table->string('descripcion')->nullable()->comment('Descripción del permiso');
            \$table->char('estado', 1)->default('A')->comment('A: Activo, I: Inactivo, E: Eliminado');
            \$table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            \$table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            \$table->timestamps();
            \$table->unique(['name', 'guard_name']);
        });
        Schema::create('roles', function (Blueprint \$table) {
            \$table->id('role_id');
            \$table->string('name')->comment('El nombre del rol');
            \$table->string('guard_name')->comment('El guard name del rol');
            // Campos adicionales
            \$table->string('descripcion')->nullable()->comment('Descripción del rol');
            \$table->char('estado', 1)->default('A')->comment('A: Activo, I: Inactivo, E: Eliminado');
            \$table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');
            \$table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');

            \$table->unique(['name', 'guard_name']);
        });
        Schema::create('modelo_tiene_permisos', function (Blueprint \$table) {
            \$table->unsignedBigInteger('permission_id');
            \$table->string('model_type');
            \$table->unsignedBigInteger('model_id');
            \$table->index(['model_id', 'model_type'], 'idx_modelo_permiso');
            \$table->foreign('permission_id')->references('permission_id')->on('permisos')->onDelete('cascade');
            \$table->primary(['permission_id', 'model_id', 'model_type'], 'pk_modelo_permiso');
        });
        Schema::create('modelo_tiene_roles', function (Blueprint \$table) {
            \$table->unsignedBigInteger('role_id');
            \$table->string('model_type');
            \$table->unsignedBigInteger('model_id');
            \$table->index(['model_id', 'model_type'], 'idx_modelo_rol');
            \$table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            \$table->primary(['role_id', 'model_id', 'model_type'], 'pk_modelo_rol');
        });
        Schema::create('rol_tiene_permisos', function (Blueprint \$table) {
            \$table->unsignedBigInteger('permission_id');
            \$table->unsignedBigInteger('role_id');
            \$table->foreign('permission_id')->references('permission_id')->on('permisos')->onDelete('cascade');
            \$table->foreign('role_id')->references('role_id')->on('roles')->onDelete('cascade');
            \$table->primary(['permission_id', 'role_id'], 'pk_role_permission');
        });
    }

    public function down(): void {
        Schema::dropIfExists('rol_tiene_permisos');
        Schema::dropIfExists('modelo_tiene_roles');
        Schema::dropIfExists('modelo_tiene_permisos');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permisos');
    }
};
PHP;
        File::put($ruta, $contenidoMigracion);
        $this->info("Migración para spatie/laravel-permission creada: {$nombreArchivo}");
    }

    protected function createPermissionSeeder(): void
    {
        $rutaSeeder = database_path('seeders/PermisosSeeder.php');
        $contenidoSeeder = <<<PHP
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Permission;
// use Spatie\Permission\Models\Role;

use App\Models\Permisos;
use App\Models\Roles;

class PermisosSeeder extends Seeder {
    public function run() {
        \$resources = [
            'usuarios',
            'clientes',
            'estadospaises',
            'municipios',
            'paises',
            'productos',
            'proveedores',
            'servicios',
        ];
        \$actions = ['ver', 'crear', 'editar', 'eliminar'];
        \$permisosCreados = [];
        foreach (\$resources as \$resource) {
            foreach (\$actions as \$action) {
                \$nombrePermiso = "\$action \$resource";
                \$permiso = Permisos::firstOrCreate(
                    ['name' => \$nombrePermiso, 'guard_name' => 'web']
                );
                \$permisosCreados[] = \$permiso->name;
            }
        }
        \$master = Roles::firstOrCreate(['name' => 'Master', 'guard_name' => 'web']);
        \$administrador = Roles::firstOrCreate(['name' => 'Administrador', 'guard_name' => 'web']);
        \$operativo = Roles::firstOrCreate(['name' => 'Operativo', 'guard_name' => 'web']);
        \$master->syncPermissions(\$permisosCreados);
        \$administrador->syncPermissions(\$permisosCreados);
        \$permisosVer = array_filter(\$permisosCreados, function(\$permiso) {
            return strpos(\$permiso, 'ver ') === 0;
        });
        \$operativo->syncPermissions(\$permisosVer);
    }
}
PHP;
        File::put($rutaSeeder, $contenidoSeeder);
        $this->info('Seeder PermisosSeeder creado correctamente.');
    }
}

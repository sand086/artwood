<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GenerarModulo extends Command
{
    /**
     * El nombre y la firma del comando de consola.
     *
     * @var string
     */
    protected $signature = 'modulo:generar {nombreModulo} {--primaryKey=id} {--campos=} {--fillable=} {--guarded=} {--relations=} {--routeKeyName=} {--menu=true} {--menuSection=}';
    /**
     * La descripción del comando de consola.
     *
     * @var string
     */
    protected $description = 'Genera un módulo completo con controlador, modelo, form request, servicio, repositorio, vista y archivos JS';

    /**
     * Crea una nueva instancia del comando.
     *
     * @return void
     */
    public function handle()
    {
        $nombreModulo = $this->argument('nombreModulo');
        $primaryKey = $this->option('primaryKey');
        $campos = $this->option('campos');
        $fillable = $this->option('fillable');
        $guarded = $this->option('guarded');
        $relations = $this->option('relations');
        $routeKeyName = $this->option('routeKeyName');
        $addToMenu = $this->option('menu');
        $menuSection = $this->option('menuSection');
        $tabla = strtolower($nombreModulo);

        $nombreModuloSingular = Str::singular($nombreModulo);
        $nombreModuloPluralSnake = Str::snake(Str::pluralStudly($nombreModulo));
        $nombreModuloSingularSnake = Str::snake($nombreModuloSingular);

        // Verificar y crear directorios necesarios
        $this->createDirectory(app_path('Services'));
        $this->createDirectory(app_path('Repositories'));
        $this->createDirectory(resource_path("views/modules/{$nombreModulo}"));
        $this->createDirectory(resource_path('js'));
        $this->createDirectory(resource_path('js/modules'));
        $this->createDirectory(resource_path("js/modules/{$nombreModulo}")); // Carpeta específica para el módulo

        // Generar Modelo
        // $this->call('make:model', ['name' => $nombreModulo, '-m' => true]);
        $this->createModel($nombreModulo, $primaryKey, $fillable, $guarded, $relations, $routeKeyName);

        // Generar Migración
        $this->createMigration($nombreModulo, $tabla, $primaryKey, $campos); // Generar migración

        // Generar Controlador de Recurso
        // $this->call('make:controller', ['name' => "{$nombreModulo}Controller", '--resource' => true, '--model' => $nombreModulo]);
        $this->createController($nombreModulo, $primaryKey, $campos);

        // Agregar la ruta
        $this->createRoute($nombreModulo);

        // Agregar el enlace al menú lateral
        if ($addToMenu === 'true') {
            $this->createMenuOption($nombreModulo, $menuSection);
        }

        // Generar Form Request
        // $this->call('make:request', ['name' => "{$nombreModulo}Request"]);
        $this->createRequest($nombreModulo, $primaryKey, $fillable);

        // Crear Servicio
        $this->createService($nombreModulo);

        // Crear Repositorio
        $this->createRepository($nombreModulo, $primaryKey, $campos);

        // Crear Vista Blade
        $this->createBladeView($nombreModulo, $tabla, $campos);

        // Crear Archivos JS
        $this->createJSFiles($nombreModulo, $primaryKey, $campos, $fillable);

        $this->info("Módulo '{$nombreModulo}' generado exitosamente.");
    }

    /**
     * Obtiene el contenido de un archivo de plantilla.
     * @param string $tipo Tipo de plantilla
     * @return string Contenido de la plantilla
     */
    protected function getStub($tipo)
    {
        return file_get_contents(__DIR__ . "/stubs/{$tipo}.stub");
    }

    /**
     * Crea un directorio si no existe.
     * @param string $path Ruta del directorio
     * @return void
     */
    protected function createDirectory($path)
    {
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }
    }

    /**
     * Crea un modelo para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $primaryKey Nombre del campo de clave primaria
     * @param string $fillable Campos asignables
     * @param string $guarded Campos protegidos
     * @param string $relations Relaciones con otras tablas
     * @param string $routeKeyName Nombre del campo para las rutas
     * @return void
     */
    protected function createModel($nombreModulo, $primaryKey = null, $fillable = null, $guarded = null, $relations = null, $routeKeyName = null)
    {
        $path = app_path("Models/{$nombreModulo}.php");
        if (!File::exists($path)) {
            $contenido = $this->getStub('model');
            $contenido = str_replace('{{NombreModulo}}', $nombreModulo, $contenido);
            $contenido = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $contenido);
            $contenido = str_replace('{{primaryKey}}', $primaryKey ?: 'id', $contenido);

            // Manejar fillable
            $fillableArray = $fillable ? explode(',', $fillable) : [];
            $fillableString = $fillableArray ? "'" . implode("', '", $fillableArray) . "'" : '';
            $contenido = str_replace('// Aqui agregar los campos que son asignables', $fillableString, $contenido);

            // Manejar guarded
            $guardedArray = $guarded ? explode(',', $guarded) : [];
            $guardedString = $guardedArray ? "'" . implode("', '", $guardedArray) . "'" : '';
            $contenido = str_replace('// Aqui agregar los campos', $guardedString, $contenido);

            // Manejar relaciones
            $relationsString = '';
            if ($relations) {
                $relationsArray = explode(',', $relations);
                foreach ($relationsArray as $relation) {
                    list($name, $type, $relatedModel) = explode(':', $relation);
                    $relationsString .= "
        public function {$name}()
        {
            return \$this->{$type}({$relatedModel}::class);
        }
        ";
                }
            }
            $contenido = str_replace('// Opcional: Definir relaciones con otras tablas', $relationsString, $contenido);

            // Manejar routeKeyName
            $routeKeyNameString = $routeKeyName ? "
        public function getRouteKeyName()
        {
            return '{$routeKeyName}';
        }
        " : '';
            $contenido = str_replace('// Suponiendo que quieres utilizar "slug" en lugar de "id" para las rutas.', $routeKeyNameString, $contenido);

            File::put($path, $contenido);
        }
    }

    /**
     * Crea una migración para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $tabla Nombre de la tabla
     * @param string $primaryKey Nombre del campo de clave primaria
     * @param string $campos Campos del modelo
     * @return void
     */
    protected function createMigration($nombreModulo, $tabla, $primaryKey, $campos = null)
    {
        $timestamp = now()->format('Y_m_d_His');
        $migrationFileName = "{$timestamp}_create_{$tabla}_table.php";
        $path = database_path("migrations/{$migrationFileName}");

        if (!File::exists($path)) {
            $contenido = $this->getStub('migration');
            $contenido = str_replace('{{NombreTabla}}', $tabla, $contenido);
            $contenido = str_replace('{{primaryKey}}', "'" . $primaryKey . "'", $contenido);

            $camposString = '';
            if ($campos) {
                $camposArray = explode(',', $campos);
                foreach ($camposArray as $campo) {
                    $campoParts = explode(':', $campo);
                    $nombreCampo = $campoParts[0];
                    $tipoCampo = $campoParts[1] ?? 'string'; // Tipo por defecto es string
                    if (!in_array($nombreCampo, ['estado', 'fecha_registro', 'fecha_actualizacion']))
                        $camposString .= "\$table->{$tipoCampo}('{$nombreCampo}')->comment('El dato {$nombreCampo} del {$nombreModulo}');\n            ";
                    elseif ($nombreCampo === 'estado')
                        $camposString .= "\$table->enum('estado', ['A', 'I', 'E'])->default('A')->nullable(false)->comment('El estado del registro, A:ACTIVO, I:INACTIVO, E:ELIMINADO');\n            ";
                    elseif ($nombreCampo === 'fecha_registro')
                        $camposString .= "\$table->timestamp('fecha_registro')->useCurrent()->comment('El dato fecha de registro del registro');\n            ";
                    elseif ($nombreCampo === 'fecha_actualizacion')
                        $camposString .= "\$table->timestamp('fecha_actualizacion')->useCurrentOnUpdate()->nullable()->comment('El dato fecha de actualizacion del registro');\n            ";
                }
            } else {
                $camposString = "\$table->string('nombre');\n            \$table->text('descripcion')->nullable();\n            "; // Campos por defecto
            }

            $contenido = str_replace('{{campos}}', $camposString, $contenido);
            File::put($path, $contenido);
        }
    }

    /**
     * Crea un controlador para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $primaryKey Nombre del campo de clave primaria
     * @param string $campos Campos del modelo
     * @return void
     */
    protected function createController($nombreModulo, $primaryKey, $campos)
    {
        $path = app_path("Http/Controllers/{$nombreModulo}Controller.php");
        if (!File::exists($path)) {
            // $nombreModuloSingular = Str::singular($nombreModulo);
            // $nombreModuloPluralSnake = Str::snake(Str::pluralStudly($nombreModulo));
            // $nombreModuloSingularSnake = Str::snake($nombreModuloSingular);

            $contenido = $this->getStub('controller');
            $contenido = str_replace('{{NombreModulo}}', $nombreModulo, $contenido);
            $contenido = str_replace('{{nombreModulo}}', Str::lcfirst($nombreModulo), $contenido);
            $contenido = str_replace('{{nombreModuloMin}}', Str::lower($nombreModulo), $contenido);
            $contenido = str_replace('{{nombreModuloSingular}}', Str::lcfirst(Str::singular($nombreModulo)), $contenido);
            $contenido = str_replace('{{nombreModelo}}', Str::lower(Str::singular($nombreModulo)), $contenido);
            $contenido = str_replace('{{primaryKey}}', $primaryKey, $contenido);

            // Generar la configuración de columnas para DataTable
            $columnsConfig = '';
            if ($campos) {
                $camposArray = explode(',', $campos);
                foreach ($camposArray as $campo) {
                    $nombreCampo = explode(':', $campo)[0];
                    $columnsConfig .= "                ['data' => '{$nombreCampo}', 'field' => '{$nombreCampo}'],\n";
                }
            } else {
                // Si no hay campos, generar columnas por defecto
                $columnsConfig = "                ['data' => 'id', 'field' => 'id'],\n            ['data' => 'nombre', 'field' => 'nombre'],\n";
            }
            $contenido = str_replace('// Configuración de columnas DataTable', $columnsConfig, $contenido);

            File::put($path, $contenido);
        }
    }

    /**
     * Agrega una ruta al archivo de rutas.
     * @param string $nombreModulo Nombre del módulo
     * @return void
     */
    protected function createRoute($nombreModulo)
    {
        $routePath = base_path('routes/web.php');
        $controllerName = "{$nombreModulo}Controller";
        $controllerUseStatement = "use App\Http\Controllers\\{$controllerName};";
        $routeDefinition = "Route::resource('" . Str::lower($nombreModulo) . "', {$controllerName}::class);";
        // $routeDefinition = "Route::resource('" . Str::snake(Str::pluralStudly($nombreModulo)) . "', {$controllerName}::class);";

        $routeContent = File::get($routePath);

        // Verificar si el controlador ya está en los "use"
        if (strpos($routeContent, $controllerUseStatement) === false) {
            // Encontrar la última declaración "use"
            $lastUsePosition = strrpos($routeContent, 'use ');
            if ($lastUsePosition !== false) {
                $lastUseEndPosition = strpos($routeContent, ';', $lastUsePosition) + 1;
                $routeContent = substr_replace($routeContent, "\n" . $controllerUseStatement, $lastUseEndPosition, 0);
            }
        }

        // Verificar si la ruta ya existe
        if (strpos($routeContent, $routeDefinition) === false) {
            // Encontrar el final de la sección de rutas
            $lastRoutePosition = strrpos($routeContent, ');');
            if ($lastRoutePosition !== false) {
                $lastRouteEndPosition = strpos($routeContent, ';', $lastRoutePosition) + 1;
                $routeContent = substr_replace($routeContent, "\n" . $routeDefinition, $lastRouteEndPosition, 0);
            }
        }

        File::put($routePath, $routeContent);
    }

    /**
     * Agrega una opción al menú lateral.
     * @param string $nombreModulo Nombre del módulo
     * @param string $seccion Seccion del menú
     * @return void
     */
    protected function createMenuOption($nombreModulo, $seccion = null)
    {
        $sidebarPath = resource_path('views/partials/sidebar.blade.php');
        $moduleNameMin = Str::lower($nombreModulo);
        $moduleNameDisplay = Str::title(str_replace('_', ' ', Str::snake($nombreModulo)));

        $linkContent = "
            <li>
                <a href=\"{$moduleNameMin}\" class=\"flex items-center gap-3 p-2 rounded-md text-gray-700 hover:bg-gray-100\">
                    <i data-lucide=\"square-minus\" class=\"w-6 h-6 flex-shrink-0 text-gray-600\"></i>
                    <span x-show=\"sidebarOpen\" x-transition:opacity>{$moduleNameDisplay}</span>
                </a>
            </li>
        ";

        $sidebarContent = File::get($sidebarPath);

        if ($seccion) {
            $seccionInicio = "{{-- inicio seccion {$seccion} --}}";
            $seccionFin = "{{-- fin seccion {$seccion} --}}";

            $inicioPosicion = strpos($sidebarContent, $seccionInicio);
            $finPosicion = strpos($sidebarContent, $seccionFin);

            if ($inicioPosicion !== false && $finPosicion !== false) {
                // Insertar la opción dentro de la sección especificada
                $insertarPosicion = $finPosicion;
                $sidebarContent = substr_replace($sidebarContent, $linkContent, $insertarPosicion, 0);
            } else {
                // La sección no existe, agregar al final del menú
                $lastListItemPosition = strrpos($sidebarContent, '</ul>');
                if ($lastListItemPosition !== false) {
                    $sidebarContent = substr_replace($sidebarContent, $linkContent, $lastListItemPosition, 0);
                }
            }
        } else {
            // No se especificó la sección, agregar al final del menú
            $lastListItemPosition = strrpos($sidebarContent, '</ul>');
            if ($lastListItemPosition !== false) {
                $sidebarContent = substr_replace($sidebarContent, $linkContent, $lastListItemPosition, 0);
            }
        }

        File::put($sidebarPath, $sidebarContent);
    }

    /**
     * Crea un Form Request para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $primaryKey Nombre del campo de clave primaria
     * @param string $campos Campos del modelo
     * @return void
     */
    protected function createRequest($nombreModulo, $primaryKey, $campos)
    {
        $path = app_path("Http/Requests/{$nombreModulo}Request.php");
        if (!File::exists($path)) {
            $contenido = $this->getStub('request');
            $contenido = str_replace('{{NombreModulo}}', $nombreModulo, $contenido);

            $rules = [];
            $messages = [];
            if ($campos) {
                $camposArray = explode(',', $campos);
                foreach ($camposArray as $campo) {
                    $nombreCampo = explode(':', $campo)[0]; // Obtener solo el nombre del campo
                    if ($nombreCampo !== $primaryKey) { // Excluir la clave primaria
                        $rules[] = "'{$nombreCampo}' => 'required'";
                        $messages[] = "'{$nombreCampo}.required' => 'El dato {$nombreCampo} es requerido.'";
                    }
                }
            }

            $rulesString = implode(",\n            ", $rules);
            $messagesString = implode(",\n            ", $messages);

            $contenido = str_replace('// Reglas de validación aquí', $rulesString, $contenido);
            $contenido = str_replace('// Mensajes de error personalizados aquí', $messagesString, $contenido);

            File::put($path, $contenido);
        }
    }

    /**
     * Crea un servicio para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @return void
     */
    protected function createService($nombreModulo)
    {
        $path = app_path("Services/{$nombreModulo}Service.php");
        if (!File::exists($path)) {
            $contenido = $this->getStub('service');
            $contenido = str_replace('{{NombreModulo}}', $nombreModulo, $contenido);
            $contenido = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $contenido);
            File::put($path, $contenido);
        }
    }

    /**
     * Crea un repositorio para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $primaryKey Nombre del campo de clave primaria
     * @param string $campos Campos del modelo
     * @return void
     */
    protected function createRepository($nombreModulo, $primaryKey = null, $campos = null)
    {
        if (!$primaryKey) {
            $primaryKey = (new ("App\\Models\\" . $nombreModulo))->getKeyName();
        }

        $path = app_path("Repositories/{$nombreModulo}Repository.php");
        if (!File::exists($path)) {
            $contenido = $this->getStub('repository');
            $contenido = str_replace('{{NombreModulo}}', $nombreModulo, $contenido);
            $contenido = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $contenido);
            $contenido = str_replace('{{primaryKey}}', $primaryKey, $contenido);

            // Manejar los campos
            if ($campos) {
                $camposArray = explode(',', $campos);
                $camposSelect = "'" . implode("', '", $camposArray) . "'";
                $contenido = str_replace('{{camposSelect}}', $camposSelect, $contenido);
            } else {
                $contenido = str_replace('{{camposSelect}}', "'*'", $contenido); // Seleccionar todos los campos por defecto
            }

            File::put($path, $contenido);
        }
    }

    /**
     * Crea una vista Blade para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $tabla Nombre de la tabla
     * @param string $campos Campos del modelo
     * @return void
     */
    protected function createBladeView($nombreModulo, $tabla, $campos = null)
    {
        $path = resource_path("views/modules/{$nombreModulo}/index.blade.php");
        if (!File::exists($path)) {
            $contenido = $this->getStub('index.blade');
            $contenido = str_replace('{{NombreModulo}}', $nombreModulo, $contenido);
            $contenido = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $contenido);
            $contenido = str_replace('{{Titulo}}', Str::title(str_replace('_', ' ', Str::snake($nombreModulo))), $contenido);

            // Generar los títulos de las columnas del DATATABLE
            if ($campos) {
                $titulosColumnas = '';
                $camposArray = explode(',', $campos);

                // Generar los campos del formulario
                $camposFormulario = '';
                foreach ($camposArray as $campo) {
                    if (!in_array($campo, ['estado', 'fecha_registro', 'fecha_actualizacion'])) {
                        $campo = trim($campo);
                        $label = $this->formatearLabel($campo);
                        if (str_ends_with($campo, '_id')) {
                            // Obtener el nombre de la tabla foránea
                            $tablaForanea = $this->generarNombreTablaForanea($campo);
                            // Generar un componente x-form-select para llaves foráneas
                            $camposFormulario .= "
                            <div>
                                <x-form-select
                                    label=\"{$label}\"
                                    name=\"{$campo}\"
                                    id=\"{$campo}\"
                                    table=\"{$tablaForanea}\"
                                    valueField=\"{$campo}\"
                                    labelField=\"nombre\"
                                    :where=\"['estado' => 'A']\"
                                    :orderBy=\"['nombre', 'asc']\"
                                    placeholder=\"Seleccione un {$label}\"
                                />
                            </div>
                            ";
                        } else {
                            $camposFormulario .= "
                            <div>
                                <label for=\"{$campo}\" class=\"art-label-custom\">{$label}</label>
                                <input type=\"text\" id=\"{$campo}\" name=\"{$campo}\" class=\"art-input-custom\" required>
                            </div>
                            ";
                        }
                    }
                }
                // Agregar los campos para auditoria: estado, fecha_registro, fecha_actualizacion al final del formulario
                // $camposFormulario .= "
                //         <x-form-auditoria/>
                // ";
                $contenido = str_replace('{{formularioCampos}}', $camposFormulario, $contenido);
            } else {
                // $contenido = str_replace('{{datatableTitulos}}', '{{-- Aqui van los titulos de las columnas visibles del datatable --}}', $contenido);
                $contenido = str_replace('{{formularioCampos}}', '{{-- Aqui van los campos del formulario --}}', $contenido);
            }

            File::put($path, $contenido);
        }
    }

    /**
     * Crea los archivos JS para el módulo.
     * @param string $nombreModulo Nombre del módulo
     * @param string $primaryKey Nombre del campo de clave primaria
     * @param string $campos Campos del modelo
     * @param string $fillable Campos asignables
     * @return void
     */
    protected function createJSFiles($nombreModulo, $primaryKey, $campos, $fillable)
    {
        $modulePath = resource_path("js/modules/{$nombreModulo}");

        // Crear config.js
        // $configContent = $this->getStub('config.js');
        // $configContent = str_replace('{{NombreModulo}}', $nombreModulo, $configContent);
        // $configContent = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $configContent);
        // $configContent = str_replace('{{formFields}}', $fillable ? "'" . implode("', '", explode(',', $fillable)) . "'" : '', $configContent);
        // File::put("{$modulePath}/config.js", $configContent);

        // Crear index.js
        $indexContent = $this->getStub('index.js');

        $indexContent = str_replace('{{primaryKey}}', $primaryKey, $indexContent);
        $indexContent = str_replace('{{NombreModulo}}', $nombreModulo, $indexContent);
        $indexContent = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $indexContent);
        $indexContent = str_replace('{{formFields}}', $fillable ? "'" . implode("', '", explode(',', $fillable)) . "'" : '', $indexContent);

        $dataTableColumns = '';
        if ($campos) {
            $camposArray = explode(',', $campos);
            foreach ($camposArray as $campo) {
                $titulo = $this->formatearLabel(trim($campo));
                if (!in_array($campo, ['fecha_registro', 'fecha_actualizacion']))
                    $dataTableColumns .= "{ data: '{$campo}', name: '{$campo}', title: '{$titulo}' },\n            ";
            }
            $dataTableColumns .= "{ data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }\n            ";
        } else {
            $dataTableColumns = "{ data: 'id', name: 'id' },\n            { data: 'nombre', name: 'nombre' },\n            { data: 'descripcion', name: 'descripcion' },\n            { data: 'created_at', name: 'created_at' },\n            { data: 'updated_at', name: 'updated_at' },\n            ";
        }
        $indexContent = str_replace('{{dataTableColumns}}', $dataTableColumns, $indexContent);

        File::put("{$modulePath}/index.js", $indexContent);

        // Crear datatable.js
        // $datatableContent = $this->getStub('datatable.js');
        // $dataTableColumns = '';
        // if ($campos) {
        //     $camposArray = explode(',', $campos);
        //     foreach ($camposArray as $campo) {
        //         $titulo = $this->formatearLabel(trim($campo));
        //         if( !in_array($campo, ['fecha_registro','fecha_actualizacion']) )
        //             $dataTableColumns .= "{ data: '{$campo}', name: '{$campo}', title: '{$titulo}' },\n            ";
        //     }
        //     $dataTableColumns .= "{ data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }\n            ";
        // } else {
        //     $dataTableColumns = "{ data: 'id', name: 'id' },\n            { data: 'nombre', name: 'nombre' },\n            { data: 'descripcion', name: 'descripcion' },\n            { data: 'created_at', name: 'created_at' },\n            { data: 'updated_at', name: 'updated_at' },\n            ";
        // }

        // $datatableContent = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $datatableContent);
        // $datatableContent = str_replace('{{dataTableColumns}}', $dataTableColumns, $datatableContent);
        // File::put("{$modulePath}/datatable.js", $datatableContent);

        // Crear forms.js
        // $formsContent = $this->getStub('forms.js');
        // $formsContent = str_replace('{{nombreModulo}}', strtolower($nombreModulo), $formsContent);
        // $formsContent = str_replace('{{primaryKey}}', $primaryKey, $formsContent);
        // File::put("{$modulePath}/forms.js", $formsContent);
    }

    /**
     * Formatea un campo de la base de datos para mostrarlo como etiqueta.
     * @param string $campo Nombre del campo
     * @return string Etiqueta formateada
     */
    protected function formatearLabel($campo)
    {
        $palabras = explode('_', $campo);
        $label = '';
        foreach ($palabras as $palabra) {
            if (strtolower($palabra) !== 'id') { // Ignorar la palabra "id"
                $label .= ucfirst($palabra) . ' ';
            }
        }
        return trim($label);
    }

    /**
     * Genera el nombre de la tabla foránea a partir del nombre del campo.
     * @param string $campo Nombre del campo
     * @return string Nombre de la tabla foránea
     */
    protected function generarNombreTablaForanea($campo)
    {
        // Eliminar "_id" del nombre del campo
        $nombreTabla = str_replace('_id', '', $campo);

        // Dividir el nombre del campo en partes usando "_" como delimitador
        $partes = explode('_', $nombreTabla);

        // Convertir cada parte a plural y unir las partes
        $partesPlurales = array_map(function ($parte) {
            return Str::plural($parte);
        }, $partes);

        return implode('_', $partesPlurales);
    }
}

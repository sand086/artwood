<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Configuraciones;
use App\Http\Requests\ConfiguracionesRequest;
use App\Services\ConfiguracionesService;

class ConfiguracionesController extends Controller
{
    protected ConfiguracionesService $configuracioneService;

    public function __construct(ConfiguracionesService $configuracioneService)
    {
        $this->configuracioneService = $configuracioneService;
    }

    /**
     * Muestra la lista de configuraciones.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'clave', 'field' => 'clave'],
                ['data' => 'valor', 'field' => 'valor'],
                ['data' => 'tipo_dato', 'field' => 'tipo_dato'],
                ['data' => 'fecha_inicio_vigencia', 'field' => 'fecha_inicio_vigencia'],
                ['data' => 'fecha_fin_vigencia', 'field' => 'fecha_fin_vigencia'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('configuracion_id') && !empty($request->input('configuracion_id'))) {
                $filters['configuracion_id'] = $request->input('configuracion_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->configuracioneService->getDataTable($columns, $actionsConfig, 'configuraciones', 'configuracion_id', $filters);
        }

        return view('modules.Configuraciones.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo configuracione.
     */
    public function store(ConfiguracionesRequest $request)
    {
        $validated = $request->validated();

        try {
            $configuracione = $this->configuracioneService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Configuraciones guardado exitosamente.',
                'configuracione' => $configuracione,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar configuracione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el configuracione.',
            ], 500);
        }
    }

    /**
     * Muestra el configuracione solicitado.
     */
    public function edit(Configuraciones $configuracione)
    {
        return response()->json($configuracione);
    }

    /**
     * Actualiza el configuracione especificado.
     */
    public function update(ConfiguracionesRequest $request, Configuraciones $configuracione)
    {
        $validated = $request->validated();

        try {
            $this->configuracioneService->update($configuracione, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Configuraciones actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar configuracione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el configuracione.',
            ], 500);
        }
    }

    /**
     * Elimina el configuracione especificado.
     */
    public function destroy(Configuraciones $configuracione)
    {
        try {
            $this->configuracioneService->delete($configuracione);
            return response()->json([
                'success' => true,
                'message' => 'Configuraciones eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar configuracione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el configuracione.',
            ], 500);
        }
    }
}
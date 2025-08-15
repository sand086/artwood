<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TiposIdentificaciones;
use App\Http\Requests\TiposIdentificacionesRequest;
use App\Services\TiposIdentificacionesService;

class TiposIdentificacionesController extends Controller
{
    protected TiposIdentificacionesService $tiposIdentificacioneService;

    public function __construct(TiposIdentificacionesService $tiposIdentificacioneService)
    {
        $this->tiposIdentificacioneService = $tiposIdentificacioneService;
    }

    /**
     * Muestra la lista de tiposIdentificaciones.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
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
            if ($request->has('tipo_identificacion_id') && !empty($request->input('tipo_identificacion_id'))) {
                $filters['tipo_identificacion_id'] = $request->input('tipo_identificacion_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->tiposIdentificacioneService->getDataTable($columns, $actionsConfig, 'tiposidentificaciones', 'tipo_identificacion_id', $filters);
        }

        return view('modules.TiposIdentificaciones.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo tiposIdentificacione.
     */
    public function store(TiposIdentificacionesRequest $request)
    {
        $validated = $request->validated();

        try {
            $tiposIdentificacione = $this->tiposIdentificacioneService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposIdentificaciones guardado exitosamente.',
                'tiposIdentificacione' => $tiposIdentificacione,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar tiposIdentificacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiposIdentificacione.',
            ], 500);
        }
    }

    /**
     * Muestra el tiposIdentificacione solicitado.
     */
    public function edit(TiposIdentificaciones $tiposidentificacione)
    {
        return response()->json($tiposidentificacione);
    }

    /**
     * Actualiza el tiposIdentificacione especificado.
     */
    public function update(TiposIdentificacionesRequest $request, TiposIdentificaciones $tiposidentificacione)
    {
        $validated = $request->validated();

        try {
            $this->tiposIdentificacioneService->update($tiposidentificacione, $validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposIdentificaciones actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tiposIdentificacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tiposIdentificacione.',
            ], 500);
        }
    }

    /**
     * Elimina el tiposIdentificacione especificado.
     */
    public function destroy(TiposIdentificaciones $tiposidentificacione)
    {
        try {
            $this->tiposIdentificacioneService->delete($tiposidentificacione);
            return response()->json([
                'success' => true,
                'message' => 'TiposIdentificaciones eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar tiposIdentificacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tiposIdentificacione.',
            ], 500);
        }
    }
}
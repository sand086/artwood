<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TiposProyectos;
use App\Http\Requests\TiposProyectosRequest;
use App\Services\TiposProyectosService;

class TiposProyectosController extends Controller
{
    protected TiposProyectosService $tiposProyectoService;

    public function __construct(TiposProyectosService $tiposProyectoService)
    {
        $this->tiposProyectoService = $tiposProyectoService;
    }

    /**
     * Muestra la lista de tiposProyectos.
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
            if ($request->has('tipo_proyecto_id') && !empty($request->input('tipo_proyecto_id'))) {
                $filters['tipo_proyecto_id'] = $request->input('tipo_proyecto_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->tiposProyectoService->getDataTable($columns, $actionsConfig, 'tiposproyectos', 'tipo_proyecto_id', $filters);
        }

        return view('modules.TiposProyectos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo tiposProyecto.
     */
    public function store(TiposProyectosRequest $request)
    {
        $validated = $request->validated();

        try {
            $tiposProyecto = $this->tiposProyectoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposProyectos guardado exitosamente.',
                'tiposProyecto' => $tiposProyecto,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar tiposProyecto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiposProyecto.',
            ], 500);
        }
    }

    /**
     * Muestra el tiposProyecto solicitado.
     */
    public function edit(TiposProyectos $tiposproyecto)
    {
        return response()->json($tiposproyecto);
    }

    /**
     * Actualiza el tiposProyecto especificado.
     */
    public function update(TiposProyectosRequest $request, TiposProyectos $tiposproyecto)
    {
        $validated = $request->validated();

        try {
            $this->tiposProyectoService->update($tiposproyecto, $validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposProyectos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tiposProyecto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tiposProyecto.',
            ], 500);
        }
    }

    /**
     * Elimina el tiposProyecto especificado.
     */
    public function destroy(TiposProyectos $tiposproyecto)
    {
        try {
            $this->tiposProyectoService->delete($tiposproyecto);
            return response()->json([
                'success' => true,
                'message' => 'TiposProyectos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar tiposProyecto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tiposProyecto.',
            ], 500);
        }
    }
}
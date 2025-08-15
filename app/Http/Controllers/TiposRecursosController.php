<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TiposRecursos;
use App\Http\Requests\TiposRecursosRequest;
use App\Services\TiposRecursosService;

class TiposRecursosController extends Controller
{
    protected TiposRecursosService $tiposRecursoService;

    public function __construct(TiposRecursosService $tiposRecursoService)
    {
        $this->tiposRecursoService = $tiposRecursoService;
    }

    /**
     * Muestra la lista de tiposRecursos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'tabla_referencia', 'field' => 'tabla_referencia'],
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
            if ($request->has('tipo_recurso_id') && !empty($request->input('tipo_recurso_id'))) {
                $filters['tipo_recurso_id'] = $request->input('tipo_recurso_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->tiposRecursoService->getDataTable($columns, $actionsConfig, 'tiposrecursos', 'tipo_recurso_id', $filters);
        }

        return view('modules.TiposRecursos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo tiposRecurso.
     */
    public function store(TiposRecursosRequest $request)
    {
        $validated = $request->validated();

        try {
            $tiposRecurso = $this->tiposRecursoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposRecursos guardado exitosamente.',
                'tiposRecurso' => $tiposRecurso,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar tiposRecurso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiposRecurso.',
            ], 500);
        }
    }

    /**
     * Muestra el tiposRecurso solicitado.
     */
    public function edit(TiposRecursos $tiposrecurso)
    {
        return response()->json($tiposrecurso);
    }

    /**
     * Actualiza el tiposRecurso especificado.
     */
    public function update(TiposRecursosRequest $request, TiposRecursos $tiposrecurso)
    {
        $validated = $request->validated();

        try {
            $this->tiposRecursoService->update($tiposrecurso, $validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposRecursos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tiposRecurso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tiposRecurso.',
            ], 500);
        }
    }

    /**
     * Elimina el tiposRecurso especificado.
     */
    public function destroy(TiposRecursos $tiposrecurso)
    {
        try {
            $this->tiposRecursoService->delete($tiposrecurso);
            return response()->json([
                'success' => true,
                'message' => 'TiposRecursos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar tiposRecurso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tiposRecurso.',
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ProcesosActividades;
use App\Http\Requests\ProcesosActividadesRequest;
use App\Services\ProcesosActividadesService;

class ProcesosActividadesController extends Controller
{
    protected ProcesosActividadesService $procesosActividadeService;

    public function __construct(ProcesosActividadesService $procesosActividadeService)
    {
        $this->procesosActividadeService = $procesosActividadeService;
    }

    /**
     * Muestra la lista de procesosActividades.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'proceso_id', 'field' => 'proceso_id'],
                ['data' => 'area_id', 'field' => 'area_id'],
                ['data' => 'unidad_medida_id', 'field' => 'unidad_medida_id'],
                ['data' => 'tiempo_estimado', 'field' => 'tiempo_estimado'],
                ['data' => 'costo_estimado', 'field' => 'costo_estimado'],
                ['data' => 'riesgos', 'field' => 'riesgos'],
                ['data' => 'observaciones', 'field' => 'observaciones'],
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
            if ($request->has('proceso_actividad_id') && !empty($request->input('proceso_actividad_id'))) {
                $filters['proceso_actividad_id'] = $request->input('proceso_actividad_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->procesosActividadeService->getDataTable($columns, $actionsConfig, 'procesosactividades', 'proceso_actividad_id', $filters);
        }

        return view('modules.ProcesosActividades.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo procesosActividade.
     */
    public function store(ProcesosActividadesRequest $request)
    {
        $validated = $request->validated();

        try {
            $procesosActividade = $this->procesosActividadeService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Actividad guardado exitosamente.',
                'procesosActividade' => $procesosActividade,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar la Actividad', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la Actividad.',
            ], 500);
        }
    }

    /**
     * Muestra el procesosActividade solicitado.
     */
    public function edit(ProcesosActividades $procesosactividade)
    {
        return response()->json($procesosactividade);
    }

    /**
     * Actualiza el procesosActividade especificado.
     */
    public function update(ProcesosActividadesRequest $request, ProcesosActividades $procesosactividade)
    {
        $validated = $request->validated();

        try {
            $this->procesosActividadeService->update($procesosactividade, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Actividad actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la Actividad', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la Actividad.',
            ], 500);
        }
    }

    /**
     * Elimina el procesosActividade especificado.
     */
    public function destroy(ProcesosActividades $procesosactividade)
    {
        try {
            $this->procesosActividadeService->delete($procesosactividade);
            return response()->json([
                'success' => true,
                'message' => 'Actividad eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la Actividad', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la Actividad.',
            ], 500);
        }
    }
}
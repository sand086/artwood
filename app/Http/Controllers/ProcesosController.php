<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Procesos;
use App\Http\Requests\ProcesosRequest;
use App\Services\ProcesosService;

class ProcesosController extends Controller
{
    protected ProcesosService $procesoService;

    public function __construct(ProcesosService $procesoService)
    {
        $this->procesoService = $procesoService;
    }

    /**
     * Muestra la lista de procesos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'descripcion', 'field' => 'descripcion'],
            ['data' => 'presupuesto_estimado', 'field' => 'presupuesto_estimado'],
            ['data' => 'fecha_estimada', 'field' => 'fecha_estimada'],
            ['data' => 'comentarios', 'field' => 'comentarios'],
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
            if ($request->has('proceso_id') && !empty($request->input('proceso_id'))) {
                $filters['proceso_id'] = $request->input('proceso_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->procesoService->getDataTable($columns, $actionsConfig, 'procesos', 'proceso_id', $filters);
        }

        return view('modules.Procesos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo proceso.
     */
    public function store(ProcesosRequest $request)
    {
        $validated = $request->validated();

        try {
            $proceso = $this->procesoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Procesos guardado exitosamente.',
                'proceso' => $proceso,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar proceso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el proceso.',
            ], 500);
        }
    }

    /**
     * Muestra el proceso solicitado.
     */
    public function edit(Procesos $proceso)
    {
        return response()->json($proceso);
    }

    /**
     * Actualiza el proceso especificado.
     */
    public function update(ProcesosRequest $request, Procesos $proceso)
    {
        $validated = $request->validated();

        try {
            $this->procesoService->update($proceso, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Procesos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar proceso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proceso.',
            ], 500);
        }
    }

    /**
     * Elimina el proceso especificado.
     */
    public function destroy(Procesos $proceso)
    {
        try {
            $this->procesoService->delete($proceso);
            return response()->json([
                'success' => true,
                'message' => 'Procesos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar proceso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proceso.',
            ], 500);
        }
    }
}
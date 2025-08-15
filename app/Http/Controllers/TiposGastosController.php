<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TiposGastos;
use App\Http\Requests\TiposGastosRequest;
use App\Services\TiposGastosService;

class TiposGastosController extends Controller
{
    protected TiposGastosService $tiposGastoService;

    public function __construct(TiposGastosService $tiposGastoService)
    {
        $this->tiposGastoService = $tiposGastoService;
    }

    /**
     * Muestra la lista de tiposGastos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'prioridad', 'field' => 'prioridad'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->tiposGastoService->getDataTable($columns, $actionsConfig, 'tiposgastos', 'tipo_gasto_id');
        }

        return view('modules.TiposGastos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo tiposGasto.
     */
    public function store(TiposGastosRequest $request)
    {
        $validated = $request->validated();

        try {
            $tiposGasto = $this->tiposGastoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposGastos guardado exitosamente.',
                'tiposGasto' => $tiposGasto,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar tiposGasto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiposGasto.',
            ], 500);
        }
    }

    /**
     * Muestra el tiposGasto solicitado.
     */
    public function edit(TiposGastos $tiposgasto)
    {
        return response()->json($tiposgasto);
    }

    /**
     * Actualiza el tiposGasto especificado.
     */
    public function update(TiposGastosRequest $request, TiposGastos $tiposgasto)
    {
        $validated = $request->validated();

        try {
            $this->tiposGastoService->update($tiposgasto, $validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposGastos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tiposGasto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tiposGasto.',
            ], 500);
        }
    }

    /**
     * Elimina el tiposGasto especificado.
     */
    public function destroy(TiposGastos $tiposgasto)
    {
        try {
            $this->tiposGastoService->delete($tiposgasto);
            return response()->json([
                'success' => true,
                'message' => 'TiposGastos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar tiposGasto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tiposGasto.',
            ], 500);
        }
    }
}
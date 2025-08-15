<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\UnidadesMedidas;
use App\Http\Requests\UnidadesMedidasRequest;
use App\Services\UnidadesMedidasService;

class UnidadesMedidasController extends Controller
{
    protected UnidadesMedidasService $unidadesMedidaService;

    public function __construct(UnidadesMedidasService $unidadesMedidaService)
    {
        $this->unidadesMedidaService = $unidadesMedidaService;
    }

    /**
     * Muestra la lista de unidadesMedidas.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'categoria', 'field' => 'categoria'],
                ['data' => 'simbolo', 'field' => 'simbolo'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->unidadesMedidaService->getDataTable($columns, $actionsConfig, 'unidadesmedidas', 'unidad_medida_id');
        }

        return view('modules.UnidadesMedidas.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo unidadesMedida.
     */
    public function store(UnidadesMedidasRequest $request)
    {
        $validated = $request->validated();

        try {
            $unidadesMedida = $this->unidadesMedidaService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Unidad de Medida guardado exitosamente.',
                'unidadesMedida' => $unidadesMedida,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar unidadesMedida', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la unidad de Medida.',
            ], 500);
        }
    }

    /**
     * Muestra el unidadesMedida solicitado.
     */
    public function edit(UnidadesMedidas $unidadesmedida)
    {
        return response()->json($unidadesmedida);
    }

    /**
     * Actualiza el unidadesMedida especificado.
     */
    public function update(UnidadesMedidasRequest $request, UnidadesMedidas $unidadesmedida)
    {
        $validated = $request->validated();

        try {
            $this->unidadesMedidaService->update($unidadesmedida, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Unidad Medida actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la unidad de Medida', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la unidad de Medida.',
            ], 500);
        }
    }

    /**
     * Elimina el unidadesMedida especificado.
     */
    public function destroy(UnidadesMedidas $unidadesmedida)
    {
        try {
            $this->unidadesMedidaService->delete($unidadesmedida);
            return response()->json([
                'success' => true,
                'message' => 'Unidad de Medida eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la unidad  de Medida', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la unidad de Medida.',
            ], 500);
        }
    }
}
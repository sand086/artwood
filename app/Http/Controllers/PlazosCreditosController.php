<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\PlazosCreditos;
use App\Http\Requests\PlazosCreditosRequest;
use App\Services\PlazosCreditosService;

class PlazosCreditosController extends Controller
{
    protected PlazosCreditosService $plazosCreditoService;

    public function __construct(PlazosCreditosService $plazosCreditoService)
    {
        $this->plazosCreditoService = $plazosCreditoService;
    }

    /**
     * Muestra la lista de plazosCreditos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->plazosCreditoService->getDataTable($columns, $actionsConfig, 'plazoscreditos', 'plazo_credito_id');
        }

        return view('modules.PlazosCreditos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo plazosCredito.
     */
    public function store(PlazosCreditosRequest $request)
    {
        $validated = $request->validated();

        try {
            $plazosCredito = $this->plazosCreditoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'PlazosCreditos guardado exitosamente.',
                'plazosCredito' => $plazosCredito,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar plazosCredito', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el plazosCredito.',
            ], 500);
        }
    }

    /**
     * Muestra el plazosCredito solicitado.
     */
    public function edit(PlazosCreditos $plazoscredito)
    {
        return response()->json($plazoscredito);
    }

    /**
     * Actualiza el plazosCredito especificado.
     */
    public function update(PlazosCreditosRequest $request, PlazosCreditos $plazoscredito)
    {
        $validated = $request->validated();

        try {
            $this->plazosCreditoService->update($plazoscredito, $validated);
            return response()->json([
                'success' => true,
                'message' => 'PlazosCreditos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar plazosCredito', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el plazosCredito.',
            ], 500);
        }
    }

    /**
     * Elimina el plazosCredito especificado.
     */
    public function destroy(PlazosCreditos $plazoscredito)
    {
        try {
            $this->plazosCreditoService->delete($plazoscredito);
            return response()->json([
                'success' => true,
                'message' => 'PlazosCreditos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar plazosCredito', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el plazosCredito.',
            ], 500);
        }
    }
}
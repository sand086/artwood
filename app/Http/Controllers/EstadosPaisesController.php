<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\EstadosPaises;
use App\Http\Requests\EstadosPaisesRequest;
use App\Services\EstadosPaisesService;

class EstadosPaisesController extends Controller
{
    protected EstadosPaisesService $estadosPaiseService;

    public function __construct(EstadosPaisesService $estadosPaiseService)
    {
        $this->estadosPaiseService = $estadosPaiseService;
    }

    /**
     * Muestra la lista de estadosPaises.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'pais_id', 'field' => 'pais_id'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->estadosPaiseService->getDataTable($columns, $actionsConfig, 'estadospaises', 'estado_pais_id');
        }

        return view('modules.EstadosPaises.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo estadosPaise.
     */
    public function store(EstadosPaisesRequest $request)
    {
        $validated = $request->validated();

        try {
            $estadosPaise = $this->estadosPaiseService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'EstadosPaises guardado exitosamente.',
                'estadosPaise' => $estadosPaise,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar estadosPaise', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el estadosPaise.',
            ], 500);
        }
    }

    /**
     * Muestra el estadosPaise solicitado.
     */
    public function edit(EstadosPaises $estadospaise)
    {
        return response()->json($estadospaise);
    }

    /**
     * Actualiza el estadosPaise especificado.
     */
    public function update(EstadosPaisesRequest $request, EstadosPaises $estadospaise)
    {
        $validated = $request->validated();

        try {
            $this->estadosPaiseService->update($estadospaise, $validated);
            return response()->json([
                'success' => true,
                'message' => 'EstadosPaises actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar estadosPaise', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estadosPaise.',
            ], 500);
        }
    }

    /**
     * Elimina el estadosPaise especificado.
     */
    public function destroy(EstadosPaises $estadospaise)
    {
        try {
            $this->estadosPaiseService->delete($estadospaise);
            return response()->json([
                'success' => true,
                'message' => 'EstadosPaises eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar estadosPaise', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el estadosPaise.',
            ], 500);
        }
    }
}
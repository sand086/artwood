<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Paises;
use App\Http\Requests\PaisesRequest;
use App\Services\PaisesService;

class PaisesController extends Controller
{
    protected PaisesService $paiseService;

    public function __construct(PaisesService $paiseService)
    {
        $this->paiseService = $paiseService;
    }

    /**
     * Muestra la lista de paises.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'codigo_iso', 'field' => 'codigo_iso'],
            ['data' => 'estado', 'field' => 'estado'],
            ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
            ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->paiseService->getDataTable($columns, $actionsConfig, 'paises', 'pais_id');
        }

        return view('modules.Paises.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo paise.
     */
    public function store(PaisesRequest $request)
    {
        $validated = $request->validated();

        try {
            $paise = $this->paiseService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Paises guardado exitosamente.',
                'paise' => $paise,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar paise', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el paise.',
            ], 500);
        }
    }

    /**
     * Muestra el paise solicitado.
     */
    public function edit(Paises $paise)
    {
        return response()->json($paise);
    }

    /**
     * Actualiza el paise especificado.
     */
    public function update(PaisesRequest $request, Paises $paise)
    {
        $validated = $request->validated();

        try {
            $this->paiseService->update($paise, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Paises actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar paise', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el paise.',
            ], 500);
        }
    }

    /**
     * Elimina el paise especificado.
     */
    public function destroy(Paises $paise)
    {
        try {
            $this->paiseService->delete($paise);
            return response()->json([
                'success' => true,
                'message' => 'Paises eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar paise', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el paise.',
            ], 500);
        }
    }
}
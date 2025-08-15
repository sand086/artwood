<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Municipios;
use App\Http\Requests\MunicipiosRequest;
use App\Services\MunicipiosService;

class MunicipiosController extends Controller
{
    protected MunicipiosService $municipioService;

    public function __construct(MunicipiosService $municipioService)
    {
        $this->municipioService = $municipioService;
    }

    /**
     * Muestra la lista de municipios.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'codigo_postal', 'field' => 'codigo_postal'],
                ['data' => 'estado_pais_id', 'field' => 'estado_pais_id'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->municipioService->getDataTable($columns, $actionsConfig, 'municipios', 'municipio_id');
        }

        return view('modules.Municipios.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo municipio.
     */
    public function store(MunicipiosRequest $request)
    {
        $validated = $request->validated();

        try {
            $municipio = $this->municipioService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Municipios guardado exitosamente.',
                'municipio' => $municipio,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar municipio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el municipio.',
            ], 500);
        }
    }

    /**
     * Muestra el municipio solicitado.
     */
    public function edit(Municipios $municipio)
    {
        return response()->json($municipio);
    }

    /**
     * Actualiza el municipio especificado.
     */
    public function update(MunicipiosRequest $request, Municipios $municipio)
    {
        $validated = $request->validated();

        try {
            $this->municipioService->update($municipio, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Municipios actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar municipio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el municipio.',
            ], 500);
        }
    }

    /**
     * Elimina el municipio especificado.
     */
    public function destroy(Municipios $municipio)
    {
        try {
            $this->municipioService->delete($municipio);
            return response()->json([
                'success' => true,
                'message' => 'Municipios eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar municipio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el municipio.',
            ], 500);
        }
    }
}
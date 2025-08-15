<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\TiposSolicitudes;
use App\Http\Requests\TiposSolicitudesRequest;
use App\Services\TiposSolicitudesService;

class TiposSolicitudesController extends Controller
{
    protected TiposSolicitudesService $tiposSolicitudeService;

    public function __construct(TiposSolicitudesService $tiposSolicitudeService)
    {
        $this->tiposSolicitudeService = $tiposSolicitudeService;
    }

    /**
     * Muestra la lista de tiposSolicitudes.
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

            return $this->tiposSolicitudeService->getDataTable($columns, $actionsConfig, 'tipossolicitudes', 'tipo_solicitud_id');
        }

        return view('modules.TiposSolicitudes.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo tiposSolicitude.
     */
    public function store(TiposSolicitudesRequest $request)
    {
        $validated = $request->validated();

        try {
            $tiposSolicitude = $this->tiposSolicitudeService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposSolicitudes guardado exitosamente.',
                'tiposSolicitude' => $tiposSolicitude,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar tiposSolicitude', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el tiposSolicitude.',
            ], 500);
        }
    }

    /**
     * Muestra el tiposSolicitude solicitado.
     */
    public function edit(TiposSolicitudes $tipossolicitude)
    {
        return response()->json($tipossolicitude);
    }

    /**
     * Actualiza el tiposSolicitude especificado.
     */
    public function update(TiposSolicitudesRequest $request, TiposSolicitudes $tipossolicitude)
    {
        $validated = $request->validated();

        try {
            $this->tiposSolicitudeService->update($tipossolicitude, $validated);
            return response()->json([
                'success' => true,
                'message' => 'TiposSolicitudes actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar tiposSolicitude', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el tiposSolicitude.',
            ], 500);
        }
    }

    /**
     * Elimina el tiposSolicitude especificado.
     */
    public function destroy(TiposSolicitudes $tipossolicitude)
    {
        try {
            $this->tiposSolicitudeService->delete($tipossolicitude);
            return response()->json([
                'success' => true,
                'message' => 'TiposSolicitudes eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar tiposSolicitude', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el tiposSolicitude.',
            ], 500);
        }
    }
}
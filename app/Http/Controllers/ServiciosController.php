<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Servicios;
use App\Http\Requests\ServiciosRequest;
use App\Services\ServiciosService;

class ServiciosController extends Controller
{
    protected ServiciosService $servicioService;

    public function __construct(ServiciosService $servicioService)
    {
        $this->servicioService = $servicioService;
    }

    /**
     * Muestra la lista de servicios.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'tiempo', 'field' => 'tiempo'],
                ['data' => 'unidad_medida_id', 'field' => 'unidad_medida_id'],
                ['data' => 'precio', 'field' => 'precio'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
            ];

            return $this->servicioService->getDataTable($columns, $actionsConfig, 'servicios', 'servicio_id');
        }

        return view('modules.Servicios.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo servicio.
     */
    public function store(ServiciosRequest $request)
    {
        $validated = $request->validated();

        try {
            $servicio = $this->servicioService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Servicios guardado exitosamente.',
                'servicio' => $servicio,
                'registro' => $servicio,
                'action' => 'servicioCreado',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar servicio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el servicio.',
            ], 500);
        }
    }

    /**
     * Muestra el servicio solicitado.
     */
    public function edit(Servicios $servicio)
    {
        return response()->json($servicio);
    }

    /**
     * Actualiza el servicio especificado.
     */
    public function update(ServiciosRequest $request, Servicios $servicio)
    {
        $validated = $request->validated();

        try {
            $this->servicioService->update($servicio, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Servicios actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar servicio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el servicio.',
            ], 500);
        }
    }

    /**
     * Elimina el servicio especificado.
     */
    public function destroy(Servicios $servicio)
    {
        try {
            $this->servicioService->delete($servicio);
            return response()->json([
                'success' => true,
                'message' => 'Servicios eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar servicio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el servicio.',
            ], 500);
        }
    }
}
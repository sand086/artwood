<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresServicios;
use App\Http\Requests\ProveedoresServiciosRequest;
use App\Services\ProveedoresServiciosService;

class ProveedoresServiciosController extends Controller
{
    protected ProveedoresServiciosService $proveedoresServicioService;

    public function __construct(ProveedoresServiciosService $proveedoresServicioService)
    {
        $this->proveedoresServicioService = $proveedoresServicioService;
    }

    /**
     * Muestra la lista de proveedoresServicios.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'proveedor_id', 'field' => 'proveedor_id'],
                ['data' => 'servicio_id', 'field' => 'servicio_id'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'detalle', 'field' => 'detalle'],
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
            if ($request->has('proveedor_id') && !empty($request->input('proveedor_id'))) {
                $filters['proveedor_id'] = $request->input('proveedor_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->proveedoresServicioService->getDataTable($columns, $actionsConfig, 'proveedoresservicios', 'proveedor_servicio_id', $filters);
        }

        return view('modules.ProveedoresServicios.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo proveedoresServicio.
     */
    public function store(ProveedoresServiciosRequest $request)
    {
        $validated = $request->validated();

        try {
            $proveedoresServicio = $this->proveedoresServicioService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Servicio del Proveedor guardado exitosamente.',
                'proveedoresServicio' => $proveedoresServicio,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar el Servicio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el Servicio.',
            ], 500);
        }
    }

    /**
     * Muestra el proveedoresServicio solicitado.
     */
    public function edit(ProveedoresServicios $proveedoresservicio)
    {
        return response()->json($proveedoresservicio);
    }

    /**
     * Actualiza el proveedoresServicio especificado.
     */
    public function update(ProveedoresServiciosRequest $request, ProveedoresServicios $proveedoresservicio)
    {
        $validated = $request->validated();

        try {
            $this->proveedoresServicioService->update($proveedoresservicio, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Servicio del Proveedor actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el Servicio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el Servicio.',
            ], 500);
        }
    }

    /**
     * Elimina el proveedoresServicio especificado.
     */
    public function destroy(ProveedoresServicios $proveedoresservicio)
    {
        try {
            $this->proveedoresServicioService->delete($proveedoresservicio);
            return response()->json([
                'success' => true,
                'message' => 'Servicio del Proveedor eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el Servicio', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el Servicio.',
            ], 500);
        }
    }
}
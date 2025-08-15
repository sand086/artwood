<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresMateriales;
use App\Http\Requests\ProveedoresMaterialesRequest;
use App\Services\ProveedoresMaterialesService;

class ProveedoresMaterialesController extends Controller
{
    protected ProveedoresMaterialesService $proveedoresMaterialeService;

    public function __construct(ProveedoresMaterialesService $proveedoresMaterialeService)
    {
        $this->proveedoresMaterialeService = $proveedoresMaterialeService;
    }

    /**
     * Muestra la lista de proveedoresMateriales.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'proveedor_id', 'field' => 'proveedor_id'],
                ['data' => 'material_id', 'field' => 'material_id'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'detalle', 'field' => 'detalle'],
                ['data' => 'stock', 'field' => 'stock'],
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
            if ($request->has('proveedor_id') && !empty($request->input('proveedor_id'))) {
                $filters['proveedor_id'] = $request->input('proveedor_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->proveedoresMaterialeService->getDataTable($columns, $actionsConfig, 'proveedoresmateriales', 'proveedor_material_id', $filters);
        }

        return view('modules.ProveedoresMateriales.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo proveedoresMateriale.
     */
    public function store(ProveedoresMaterialesRequest $request)
    {
        $validated = $request->validated();

        try {
            $proveedoresMateriale = $this->proveedoresMaterialeService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'ProveedoresMateriales guardado exitosamente.',
                'proveedoresMateriale' => $proveedoresMateriale,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar proveedoresMateriale', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el proveedoresMateriale.',
            ], 500);
        }
    }

    /**
     * Muestra el proveedoresMateriale solicitado.
     */
    public function edit(ProveedoresMateriales $proveedoresmateriale)
    {
        return response()->json($proveedoresmateriale);
    }

    /**
     * Actualiza el proveedoresMateriale especificado.
     */
    public function update(ProveedoresMaterialesRequest $request, ProveedoresMateriales $proveedoresmateriale)
    {
        $validated = $request->validated();

        try {
            $this->proveedoresMaterialeService->update($proveedoresmateriale, $validated);
            return response()->json([
                'success' => true,
                'message' => 'ProveedoresMateriales actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar proveedoresMateriale', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proveedoresMateriale.',
            ], 500);
        }
    }

    /**
     * Elimina el proveedoresMateriale especificado.
     */
    public function destroy(ProveedoresMateriales $proveedoresmateriale)
    {
        try {
            $this->proveedoresMaterialeService->delete($proveedoresmateriale);
            return response()->json([
                'success' => true,
                'message' => 'ProveedoresMateriales eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar proveedoresMateriale', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proveedoresMateriale.',
            ], 500);
        }
    }
}
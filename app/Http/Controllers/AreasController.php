<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Areas;
use App\Http\Requests\AreasRequest;
use App\Services\AreasService;

class AreasController extends Controller
{
    protected AreasService $areaService;

    public function __construct(AreasService $areaService)
    {
        $this->areaService = $areaService;
    }

    /**
     * Muestra la lista de areas.
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

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('area_id') && !empty($request->input('area_id'))) {
                $filters['area_id'] = $request->input('area_id');
            } // else {
            // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
            // o una tabla vacía para evitar mostrar todos los contactos.
            // return response()->json(['data' => []]); // Ejemplo: devolver vacío
            // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
            // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->areaService->getDataTable($columns, $actionsConfig, 'areas', 'area_id', $filters);
        }

        return view('modules.Areas.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo area.
     */
    public function store(AreasRequest $request)
    {
        $validated = $request->validated();

        try {
            $area = $this->areaService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Areas guardado exitosamente.',
                'area' => $area,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar area', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el area.',
            ], 500);
        }
    }

    /**
     * Muestra el area solicitado.
     */
    public function edit(Areas $area)
    {
        return response()->json($area);
    }

    /**
     * Actualiza el area especificado.
     */
    // app/Http/Controllers/AreasController.php

    public function update(AreasRequest $request, Areas $area)
    {
        $validated = $request->validated();

        try {
            $this->areaService->update($area, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Área actualizada correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar área', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el área.',
            ], 500);
        }
    }

    /**
     * Elimina el area especificado.
     */
    public function destroy(Areas $area)
    {
        try {
            $this->areaService->delete($area);
            return response()->json([
                'success' => true,
                'message' => 'Areas eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar area', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el area.',
            ], 500);
        }
    }
}

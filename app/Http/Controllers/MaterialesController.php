<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Materiales;
use App\Http\Requests\MaterialesRequest;
use App\Services\MaterialesService;

class MaterialesController extends Controller
{
    protected MaterialesService $materialeService;

    public function __construct(MaterialesService $materialeService)
    {
        $this->materialeService = $materialeService;
    }

    /**
     * Muestra la lista de materiales.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'unidad_medida_id', 'field' => 'unidad_medida_id'],
                ['data' => 'precio_unitario', 'field' => 'precio_unitario'],
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
            if ($request->has('material_id') && !empty($request->input('material_id'))) {
                $filters['material_id'] = $request->input('material_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->materialeService->getDataTable($columns, $actionsConfig, 'materiales', 'material_id', $filters);
        }

        return view('modules.Materiales.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo materiale.
     */
    public function store(MaterialesRequest $request)
    {
        $validated = $request->validated();

        try {
            $material = $this->materialeService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Materiales guardado exitosamente.',
                'materiale' => $material,
                'registro' => $material,
                'action' => 'materialCreado',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar materiale', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el materiale.',
            ], 500);
        }
    }

    /**
     * Muestra el materiale solicitado.
     */
    public function edit(Materiales $materiale)
    {
        return response()->json($materiale);
    }

    /**
     * Actualiza el materiale especificado.
     */
    public function update(MaterialesRequest $request, Materiales $materiale)
    {
        $validated = $request->validated();

        try {
            $this->materialeService->update($materiale, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Materiales actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar materiale', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el materiale.',
            ], 500);
        }
    }

    /**
     * Elimina el materiale especificado.
     */
    public function destroy(Materiales $materiale)
    {
        try {
            $this->materialeService->delete($materiale);
            return response()->json([
                'success' => true,
                'message' => 'Materiales eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar materiale', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el materiale.',
            ], 500);
        }
    }
}
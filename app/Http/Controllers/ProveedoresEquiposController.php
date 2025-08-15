<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ProveedoresEquipos;
use App\Http\Requests\ProveedoresEquiposRequest;
use App\Services\ProveedoresEquiposService;

class ProveedoresEquiposController extends Controller
{
    protected ProveedoresEquiposService $proveedoresEquipoService;

    public function __construct(ProveedoresEquiposService $proveedoresEquipoService)
    {
        $this->proveedoresEquipoService = $proveedoresEquipoService;
    }

    /**
     * Muestra la lista de proveedoresEquipos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'proveedor_id', 'field' => 'proveedor_id'],
                ['data' => 'equipo_id', 'field' => 'equipo_id'],
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

            return $this->proveedoresEquipoService->getDataTable($columns, $actionsConfig, 'proveedoresequipos', 'proveedor_equipo_id', $filters);
        }

        return view('modules.ProveedoresEquipos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo proveedoresEquipo.
     */
    public function store(ProveedoresEquiposRequest $request)
    {
        $validated = $request->validated();

        try {
            $proveedoresEquipo = $this->proveedoresEquipoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'ProveedoresEquipos guardado exitosamente.',
                'proveedoresEquipo' => $proveedoresEquipo,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar proveedoresEquipo', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el proveedoresEquipo.',
            ], 500);
        }
    }

    /**
     * Muestra el proveedoresEquipo solicitado.
     */
    public function edit(ProveedoresEquipos $proveedoresequipo)
    {
        return response()->json($proveedoresequipo);
    }

    /**
     * Actualiza el proveedoresEquipo especificado.
     */
    public function update(ProveedoresEquiposRequest $request, ProveedoresEquipos $proveedoresequipo)
    {
        $validated = $request->validated();

        try {
            $this->proveedoresEquipoService->update($proveedoresequipo, $validated);
            return response()->json([
                'success' => true,
                'message' => 'ProveedoresEquipos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar proveedoresEquipo', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el proveedoresEquipo.',
            ], 500);
        }
    }

    /**
     * Elimina el proveedoresEquipo especificado.
     */
    public function destroy(ProveedoresEquipos $proveedoresequipo)
    {
        try {
            $this->proveedoresEquipoService->delete($proveedoresequipo);
            return response()->json([
                'success' => true,
                'message' => 'ProveedoresEquipos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar proveedoresEquipo', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el proveedoresEquipo.',
            ], 500);
        }
    }
}
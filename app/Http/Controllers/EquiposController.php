<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Equipos;
use App\Http\Requests\EquiposRequest;
use App\Services\EquiposService;

class EquiposController extends Controller
{
    protected EquiposService $equipoService;

    public function __construct(EquiposService $equipoService)
    {
        $this->equipoService = $equipoService;
    }

    /**
     * Muestra la lista de equipos.
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
            if ($request->has('equipo_id') && !empty($request->input('equipo_id'))) {
                $filters['equipo_id'] = $request->input('equipo_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->equipoService->getDataTable($columns, $actionsConfig, 'equipos', 'equipo_id', $filters);
        }

        return view('modules.Equipos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo equipo.
     */
    public function store(EquiposRequest $request)
    {
        $validated = $request->validated();

        try {
            $equipo = $this->equipoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Equipos guardado exitosamente.',
                'equipo' => $equipo,
                'registro' => $equipo,
                'action' => 'equipoCreado',
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar equipo', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el equipo.',
            ], 500);
        }
    }

    /**
     * Muestra el equipo solicitado.
     */
    public function edit(Equipos $equipo)
    {
        return response()->json($equipo);
    }

    /**
     * Actualiza el equipo especificado.
     */
    public function update(EquiposRequest $request, Equipos $equipo)
    {
        $validated = $request->validated();

        try {
            $this->equipoService->update($equipo, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Equipos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar equipo', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el equipo.',
            ], 500);
        }
    }

    /**
     * Elimina el equipo especificado.
     */
    public function destroy(Equipos $equipo)
    {
        try {
            $this->equipoService->delete($equipo);
            return response()->json([
                'success' => true,
                'message' => 'Equipos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar equipo', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el equipo.',
            ], 500);
        }
    }
}
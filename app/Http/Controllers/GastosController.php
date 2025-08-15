<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\Gastos;
use App\Http\Requests\GastosRequest;
use App\Services\GastosService;

class GastosController extends Controller
{
    protected GastosService $gastoService;

    public function __construct(GastosService $gastoService)
    {
        $this->gastoService = $gastoService;
    }

    /**
     * Muestra la lista de gastos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'nombre', 'field' => 'nombre'],
                ['data' => 'tipo_gasto_id', 'field' => 'tipo_gasto_id'],
                ['data' => 'unidad_medida_id', 'field' => 'unidad_medida_id'],
                ['data' => 'valor_unidad', 'field' => 'valor_unidad'],
                ['data' => 'cantidad', 'field' => 'cantidad'],
                ['data' => 'valor_total', 'field' => 'valor_total'],
                ['data' => 'usuario_id', 'field' => 'usuario_id'],
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
            if ($request->has('gasto_id') && !empty($request->input('gasto_id'))) {
                $filters['gasto_id'] = $request->input('gasto_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->gastoService->getDataTable($columns, $actionsConfig, 'gastos', 'gasto_id', $filters);
        }

        return view('modules.Gastos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo gasto.
     */
    public function store(GastosRequest $request)
    {
        $validated = $request->validated();
        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        $validated['usuario_id'] = $currentUserID;

        try {
            $gasto = $this->gastoService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Gastos guardado exitosamente.',
                'gasto' => $gasto,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar gasto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el gasto.',
            ], 500);
        }
    }

    /**
     * Muestra el gasto solicitado.
     */
    public function edit(Gastos $gasto)
    {
        return response()->json($gasto);
    }

    /**
     * Actualiza el gasto especificado.
     */
    public function update(GastosRequest $request, Gastos $gasto)
    {
        $validated = $request->validated();

        try {
            $this->gastoService->update($gasto, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Gastos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar gasto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el gasto.',
            ], 500);
        }
    }

    /**
     * Elimina el gasto especificado.
     */
    public function destroy(Gastos $gasto)
    {
        try {
            $this->gastoService->delete($gasto);
            return response()->json([
                'success' => true,
                'message' => 'Gastos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar gasto', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el gasto.',
            ], 500);
        }
    }
}
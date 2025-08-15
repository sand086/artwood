<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\CotizacionesResponsables;
use App\Http\Requests\CotizacionesResponsablesRequest;
use App\Services\CotizacionesResponsablesService;

class CotizacionesResponsablesController extends Controller
{
    protected CotizacionesResponsablesService $cotizacionesResponsableService;

    public function __construct(CotizacionesResponsablesService $cotizacionesResponsableService)
    {
        $this->cotizacionesResponsableService = $cotizacionesResponsableService;
    }

    /**
     * Muestra la lista de cotizacionesResponsables.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'cotizacion_solicitud_id', 'field' => 'cotizacion_solicitud_id'],
                ['data' => 'empleado_id', 'field' => 'empleado_id'],
                ['data' => 'area_id', 'field' => 'area_id'],
                ['data' => 'responsabilidad', 'field' => 'responsabilidad'],
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
            if ($request->has('cotizacion_solicitud_id') && !empty($request->input('cotizacion_solicitud_id'))) {
                $filters['cotizacion_solicitud_id'] = $request->input('cotizacion_solicitud_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->cotizacionesResponsableService->getDataTable($columns, $actionsConfig, 'cotizacionesresponsables', 'cotizacion_responsable_id', $filters);
        }

        return view('modules.CotizacionesResponsables.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo cotizacionesResponsable.
     */
    public function store(CotizacionesResponsablesRequest $request)
    {
        $validated = $request->validated();

        try {
            $cotizacionesResponsable = $this->cotizacionesResponsableService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'CotizacionesResponsables guardado exitosamente.',
                'cotizacionesResponsable' => $cotizacionesResponsable,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar cotizacionesResponsable', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el cotizacionesResponsable.',
            ], 500);
        }
    }

    /**
     * Muestra el cotizacionesResponsable solicitado.
     */
    public function edit(CotizacionesResponsables $cotizacionesresponsable)
    {
        return response()->json($cotizacionesresponsable);
    }

    /**
     * Actualiza el cotizacionesResponsable especificado.
     */
    public function update(CotizacionesResponsablesRequest $request, CotizacionesResponsables $cotizacionesresponsable)
    {
        $validated = $request->validated();

        try {
            $this->cotizacionesResponsableService->update($cotizacionesresponsable, $validated);
            return response()->json([
                'success' => true,
                'message' => 'CotizacionesResponsables actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar cotizacionesResponsable', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cotizacionesResponsable.',
            ], 500);
        }
    }

    /**
     * Elimina el cotizacionesResponsable especificado.
     */
    public function destroy(CotizacionesResponsables $cotizacionesresponsable)
    {
        try {
            $this->cotizacionesResponsableService->delete($cotizacionesresponsable);
            return response()->json([
                'success' => true,
                'message' => 'CotizacionesResponsables eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar cotizacionesResponsable', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cotizacionesResponsable.',
            ], 500);
        }
    }
}
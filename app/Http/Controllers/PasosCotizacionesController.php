<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\PasosCotizaciones;
use App\Http\Requests\PasosCotizacionesRequest;
use App\Services\PasosCotizacionesService;

class PasosCotizacionesController extends Controller
{
    protected PasosCotizacionesService $pasosCotizacioneService;

    public function __construct(PasosCotizacionesService $pasosCotizacioneService)
    {
        $this->pasosCotizacioneService = $pasosCotizacioneService;
    }

    /**
     * Muestra la lista de pasosCotizaciones.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                            ['data' => 'nombre', 'field' => 'nombre'],
            ['data' => 'descripcion', 'field' => 'descripcion'],
            ['data' => 'tipo_cliente_id', 'field' => 'tipo_cliente_id'],
            ['data' => 'orden', 'field' => 'orden'],
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
            if ($request->has('paso_cotizacion_id') && !empty($request->input('paso_cotizacion_id'))) {
                $filters['paso_cotizacion_id'] = $request->input('paso_cotizacion_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->pasosCotizacioneService->getDataTable($columns, $actionsConfig, 'pasoscotizaciones', 'paso_cotizacion_id', $filters);
        }

        return view('modules.PasosCotizaciones.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo pasosCotizacione.
     */
    public function store(PasosCotizacionesRequest $request)
    {
        $validated = $request->validated();

        try {
            $pasosCotizacione = $this->pasosCotizacioneService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'PasosCotizaciones guardado exitosamente.',
                'pasosCotizacione' => $pasosCotizacione,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar pasosCotizacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el pasosCotizacione.',
            ], 500);
        }
    }

    /**
     * Muestra el pasosCotizacione solicitado.
     */
    public function edit(PasosCotizaciones $pasoscotizacione)
    {
        return response()->json($pasoscotizacione);
    }

    /**
     * Actualiza el pasosCotizacione especificado.
     */
    public function update(PasosCotizacionesRequest $request, PasosCotizaciones $pasoscotizacione)
    {
        $validated = $request->validated();

        try {
            $this->pasosCotizacioneService->update($pasoscotizacione, $validated);
            return response()->json([
                'success' => true,
                'message' => 'PasosCotizaciones actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar pasosCotizacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el pasosCotizacione.',
            ], 500);
        }
    }

    /**
     * Elimina el pasosCotizacione especificado.
     */
    public function destroy(PasosCotizaciones $pasoscotizacione)
    {
        try {
            $this->pasosCotizacioneService->delete($pasoscotizacione);
            return response()->json([
                'success' => true,
                'message' => 'PasosCotizaciones eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar pasosCotizacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el pasosCotizacione.',
            ], 500);
        }
    }
}
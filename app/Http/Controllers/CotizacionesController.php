<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Cotizaciones;
use App\Http\Requests\CotizacionesRequest;
use App\Services\CotizacionesService;

class CotizacionesController extends Controller
{
    protected CotizacionesService $cotizacioneService;

    public function __construct(CotizacionesService $cotizacioneService)
    {
        $this->cotizacioneService = $cotizacioneService;
    }

    /**
     * Muestra la lista de cotizaciones.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'cotizacion_analisis_id', 'field' => 'cotizacion_analisis_id'],
                ['data' => 'cliente_contacto_id', 'field' => 'cliente_contacto_id'],
                ['data' => 'plantilla_id', 'field' => 'plantilla_id'],
                ['data' => 'condiciones_comerciales', 'field' => 'condiciones_comerciales'],
                ['data' => 'datos_adicionales', 'field' => 'datos_adicionales'],
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
            if ($request->has('cotizacion_id') && !empty($request->input('cotizacion_id'))) {
                $filters['cotizacion_id'] = $request->input('cotizacion_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->cotizacioneService->getDataTable($columns, $actionsConfig, 'cotizaciones', 'cotizacion_id', $filters);
        }

        return view('modules.Cotizaciones.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo cotizacione.
     */
    public function store(CotizacionesRequest $request)
    {
        $validated = $request->validated();

        try {
            $cotizacione = $this->cotizacioneService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Cotizaciones guardado exitosamente.',
                'cotizacione' => $cotizacione,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar cotizacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el cotizacione.',
            ], 500);
        }
    }

    /**
     * Muestra el cotizacione solicitado.
     */
    public function edit(Cotizaciones $cotizacione)
    {
        $cotizacione->load('plantilla');
        $cotizacione->load('clienteContacto');
        $cotizacione->load('cotizacionSolicitud');
        return response()->json($cotizacione);
    }

    /**
     * Actualiza el cotizacione especificado.
     */
    public function update(CotizacionesRequest $request, Cotizaciones $cotizacione)
    {
        $validated = $request->validated();

        try {
            $this->cotizacioneService->update($cotizacione, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Cotizaciones actualizado correctamente.',
                'cotizacione' => $cotizacione,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar cotizacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cotizacione.',
            ], 500);
        }
    }

    /**
     * Elimina el cotizacione especificado.
     */
    public function destroy(Cotizaciones $cotizacione)
    {
        try {
            $this->cotizacioneService->delete($cotizacione);
            return response()->json([
                'success' => true,
                'message' => 'Cotizaciones eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar cotizacione', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cotizacione.',
            ], 500);
        }
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\CotizacionesRecursos;
use App\Http\Requests\CotizacionesRecursosRequest;
use App\Services\CotizacionesRecursosService;
use App\Models\CotizacionesAnalisis;
use App\Services\ConfiguracionesService;

class CotizacionesRecursosController extends Controller
{
    protected CotizacionesRecursosService $cotizacionesRecursoService;
    protected ConfiguracionesService $configuracionesService;

    public function __construct(CotizacionesRecursosService $cotizacionesRecursoService, 
                                ConfiguracionesService $configuracionesService)
    {
        $this->cotizacionesRecursoService = $cotizacionesRecursoService;
        $this->configuracionesService = $configuracionesService;
    }

    /**
     * Muestra la lista de cotizacionesRecursos.
     */
    public function index(Request $request)
    {
        $porcentajeGananciaDefault = $this->configuracionesService->getValorCacheado('PORCENTAJE_GANANCIA');

        if ($request->ajax()) {
            $columns = [
                ['data' => 'cotizacion_analisis_id', 'field' => 'cotizacion_analisis_id'],
                ['data' => 'tipo_recurso_id', 'field' => 'tipo_recurso_id'],
                ['data' => 'recurso_id', 'field' => 'recurso_id'],
                ['data' => 'proveedor_id', 'field' => 'proveedor_id'],
                ['data' => 'unidad_medida_id', 'field' => 'unidad_medida_id'],
                ['data' => 'precio_unitario', 'field' => 'precio_unitario'],
                ['data' => 'cantidad', 'field' => 'cantidad'],
                ['data' => 'costo_clave', 'field' => 'costo_clave'],
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
            if ($request->has('cotizacion_analisis_id') && !empty($request->input('cotizacion_analisis_id'))) {
                $filters['cotizacion_analisis_id'] = $request->input('cotizacion_analisis_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            // Obtener la respuesta base del DataTable
            $dataTableResponse = $this->cotizacionesRecursoService->getDataTable($columns, $actionsConfig, 'cotizacionesrecursos', 'cotizacion_recurso_id', $filters);

            // Convertir la respuesta a un array si es un JsonResponse, para poder modificarla
            // Esto es crucial si getDataTable ya retorna un JsonResponse.
            if ($dataTableResponse instanceof \Illuminate\Http\JsonResponse) {
                $data = $dataTableResponse->getData(true); // true para obtenerlo como array asociativo
            } else {
                $data = (array) $dataTableResponse; // Si retorna un array directamente
            }

            // Añadir el porcentaje de ganancia por defecto a la respuesta AJAX
            $data['porcentajeGananciaDefault'] = $porcentajeGananciaDefault ?? 0;

            return response()->json($data);
        }

        return view('modules.CotizacionesRecursos.index', [
                                                        'canAdd' => true,
                                                        'porcentajeGananciaDefault' => $porcentajeGananciaDefault ?? 0 // Valor por defecto si no se encuentra
                                                        ]);
    }

    /**
     * Almacena un nuevo cotizacionesRecurso.
     */
    public function store(CotizacionesRecursosRequest $request)
    {
        $validated = $request->validated();
        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        $validated['usuario_id'] = $currentUserID;

        if( $validated['precio_total'] == '' || $validated['precio_total'] == null ) {
            // Asegúrate de que precio_unitario y cantidad sean numéricos antes de la multiplicación
            $precioUnitario = (float) $validated['precio_unitario'];
            $cantidad = (float) $validated['cantidad'];
            $validated['precio_total'] = $precioUnitario * $cantidad;
        }

        try {
            $cotizacionesRecurso = $this->cotizacionesRecursoService->create($validated);

            // El Observer ya actualizó el análisis. Ahora solo lo leemos.
            $analisis = CotizacionesAnalisis::find($cotizacionesRecurso->cotizacion_analisis_id);

            return response()->json([
                'success' => true,
                'message' => 'Recurso guardado exitosamente.',
                'registro' => $cotizacionesRecurso,
                'tiempo_total_analisis' => $analisis->tiempo_total,
                'costo_subtotal_analisis' => $analisis->costo_subtotal,
                'costo_total_analisis' => $analisis->costo_total
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar cotizacionesRecurso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el cotizacionesRecurso.',
            ], 500);
        }
    }

    /**
     * Muestra el cotizacionesRecurso solicitado.
     */
    public function edit(CotizacionesRecursos $cotizacionesrecurso)
    {
        return response()->json($cotizacionesrecurso);
    }

    /**
     * Actualiza el cotizacionesRecurso especificado.
     */
    public function update(CotizacionesRecursosRequest $request, CotizacionesRecursos $cotizacionesrecurso)
    {
        $validated = $request->validated();

        try {
            $this->cotizacionesRecursoService->update($cotizacionesrecurso, $validated);

            // El Observer ya actualizó el análisis.
            $analisis = CotizacionesAnalisis::find($cotizacionesrecurso->cotizacion_analisis_id);

            return response()->json([
                'success' => true,
                'message' => 'Recurso actualizado correctamente.',
                'registro'=> $cotizacionesrecurso,
                'tiempo_total_analisis' => $analisis->tiempo_total,
                'costo_subtotal_analisis' => $analisis->costo_subtotal,
                'costo_total_analisis' => $analisis->costo_total
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar cotizacionesRecurso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cotizacionesRecurso.',
            ], 500);
        }
    }

    /**
     * Elimina el cotizacionesRecurso especificado.
     */
    public function destroy(CotizacionesRecursos $cotizacionesrecurso)
    {
        $analisisId = $cotizacionesrecurso->cotizacion_analisis_id;
        try {
            $this->cotizacionesRecursoService->delete($cotizacionesrecurso);

            $analisis = CotizacionesAnalisis::find($analisisId);
            $nuevoTiempoTotal = $analisis ? $analisis->tiempo_total : 0;
            $nuevoCostoSubtotal = $analisis ? $analisis->costo_subtotal : 0.00;
            $nuevoCostoTotal = $analisis ? $analisis->costo_total : 0.00;

            return response()->json([
                'success' => true,
                'message' => 'Recurso eliminado correctamente.',
                'tiempo_total_analisis' => $nuevoTiempoTotal,
                'costo_subtotal_analisis' => $nuevoCostoSubtotal,
                'costo_total_analisis' => $nuevoCostoTotal
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar cotizacionesRecurso', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cotizacionesRecurso.',
            ], 500);
        }
    }
}
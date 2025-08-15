<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\CotizacionesAnalisis;
use App\Http\Requests\CotizacionesAnalisisRequest;
use App\Services\CotizacionesAnalisisService;
use App\Services\ConfiguracionesService;

class CotizacionesAnalisisController extends Controller
{
    protected CotizacionesAnalisisService $cotizacionesAnalisiService;
    protected ConfiguracionesService $configuracionesService;

    public function __construct(CotizacionesAnalisisService $cotizacionesAnalisiService,
                                ConfiguracionesService $configuracionesService)
    {
        $this->cotizacionesAnalisiService = $cotizacionesAnalisiService;
        $this->configuracionesService = $configuracionesService;
    }

    /**
     * Muestra la lista de cotizacionesAnalisis.
     */
    public function index(Request $request)
    {
        $impuestoIvaDefault = $this->configuracionesService->getValorCacheado('IMPUESTO_IVA');

        if ($request->ajax()) {
            $columns = [
                ['data' => 'cotizacion_solicitud_id', 'field' => 'cotizacion_solicitud_id'],
                ['data' => 'tipo_proyecto_id', 'field' => 'tipo_proyecto_id'],
                ['data' => 'descripcion_solicitud', 'field' => 'descripcion_solicitud'],
                ['data' => 'tiempo_total', 'field' => 'tiempo_total'],
                ['data' => 'costo_subtotal', 'field' => 'costo_subtotal'],
                ['data' => 'impuesto_iva', 'field' => 'impuesto_iva'],
                ['data' => 'costo_total', 'field' => 'costo_total'],
                ['data' => 'control_version', 'field' => 'control_version'],
                ['data' => 'usuario_id', 'field' => 'usuario_id'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
                'custom' => [
                    0 => [
                        'label' => '',
                        'route' => 'documentos.generar',
                        'method' => 'GET',
                        // 'params' => 'plantilla_id,cotizacionanalisis_id',
                        'routeParams' => [
                            'plantilla' => 'plantilla_id',
                            'registro' => 'cotizacion_analisis_id',
                        ],
                        'icon' => '/images/icons/crud/iconos_ojo_abierto.svg',
                        'iconType'=> 'img',
                        'iconSize'=> 'w-9',
                        'iconWidth'=> '30',
                        'class' => 'btn btn-primary btn-sm inline-flex items-center justify-center bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 p-1 rounded',
                        'title' => 'Generar cotizacion',
                        'target' => '_blank',
                        'condition' => [
                            'conditions' => [
                                [
                                    'field' => 'cotizacion_id', // El nombre exacto del campo en tu modelo/objeto $row
                                    // 'value' => NULL,
                                    'operator' => 'is_not_empty' // El operador de comparación
                                ]
                            ]
                        ],
                    ],
                ],
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

            // return $this->cotizacionesAnalisiService->getDataTable($columns, $actionsConfig, 'cotizacionesanalisis', 'cotizacion_analisis_id', $filters);
            // Obtener la respuesta base del DataTable
            $dataTableResponse = $this->cotizacionesAnalisiService->getDataTable($columns, $actionsConfig, 'cotizacionesanalisis', 'cotizacion_analisis_id', $filters);

            // Convertir la respuesta a un array si es un JsonResponse, para poder modificarla
            // Esto es crucial si getDataTable ya retorna un JsonResponse.
            if ($dataTableResponse instanceof \Illuminate\Http\JsonResponse) {
                $data = $dataTableResponse->getData(true); // true para obtenerlo como array asociativo
            } else {
                $data = (array) $dataTableResponse; // Si retorna un array directamente
            }

            // Añadir el porcentaje de ganancia por defecto a la respuesta AJAX
            $data['impuestoIvaDefault'] = $impuestoIvaDefault ?? 0;

            return response()->json($data);
        }

        return view('modules.CotizacionesAnalisis.index', ['canAdd' => true, 
                                                            'impuestoIvaDefault' => $impuestoIvaDefault]);
    }

    /**
     * Almacena un nuevo cotizacionesAnalisi.
     */
    public function store(CotizacionesAnalisisRequest $request)
    {
        $validated = $request->validated();
        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        $validated['usuario_id'] = $currentUserID;

        try {
            $cotizacionesAnalisi = $this->cotizacionesAnalisiService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Analisis guardado exitosamente.',
                'cotizacionesAnalisi' => $cotizacionesAnalisi,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar el Analisis', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el Analisis.',
            ], 500);
        }
    }

    /**
     * Muestra el cotizacionesAnalisi solicitado.
     */
    public function edit(CotizacionesAnalisis $cotizacionesanalisi)
    {
        $cotizacionesanalisi->load('cotizacion');
        $cotizacionesanalisi->load('cotizacionSolicitud');
        return response()->json($cotizacionesanalisi);
    }

    /**
     * Actualiza el cotizacionesAnalisi especificado.
     */
    public function update(CotizacionesAnalisisRequest $request, CotizacionesAnalisis $cotizacionesanalisi)
    {
        $validated = $request->validated();

        try {
            $this->cotizacionesAnalisiService->update($cotizacionesanalisi, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Analisis actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el Analisis', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el Analisis.',
            ], 500);
        }
    }

    /**
     * Elimina el cotizacionesAnalisi especificado.
     */
    public function destroy(CotizacionesAnalisis $cotizacionesanalisi)
    {
        try {
            $this->cotizacionesAnalisiService->delete($cotizacionesanalisi);
            return response()->json([
                'success' => true,
                'message' => 'Analisis eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar el Analisis', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el Analisis.',
            ], 500);
        }
    }

    public function create(Request $request)
    {
        $openModal = $request->query('openModal', false); // Obtiene el valor del parámetro openModal
        $cotizacionSolicitudId = $request->query('cotizacionSolicitudId', null); // Obtiene el valor del parámetro cotizacionSolicitudId
        $description = $request->query('description', null); // Obtiene el valor del parámetro description

        return view('modules.CotizacionesAnalisis.index', compact('openModal', 'cotizacionSolicitudId', 'description')); // Pasa la variable openModal a la vista
    }
}
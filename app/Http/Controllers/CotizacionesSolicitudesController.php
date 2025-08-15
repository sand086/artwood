<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\CotizacionesSolicitudes;
use App\Http\Requests\CotizacionesSolicitudesRequest;
use App\Services\CotizacionesSolicitudesService;

class CotizacionesSolicitudesController extends Controller
{
    protected CotizacionesSolicitudesService $cotizacionesSolicitudeService;

    public function __construct(CotizacionesSolicitudesService $cotizacionesSolicitudeService)
    {
        $this->cotizacionesSolicitudeService = $cotizacionesSolicitudeService;
    }

    /**
     * Muestra la lista de cotizacionesSolicitudes.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'tipo_solicitud_id', 'field' => 'tipo_solicitud_id'],
                ['data' => 'cliente_id', 'field' => 'cliente_id'],
                ['data' => 'nombre_proyecto', 'field' => 'nombre_proyecto'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'fecha_estimada', 'field' => 'fecha_estimada'],
                ['data' => 'control_version', 'field' => 'control_version'],
                ['data' => 'usuario_id', 'field' => 'usuario_id'],
                ['data' => 'estado_id', 'field' => 'estado_id'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],

            ];

            $actionsConfig = [
                'edit' => true,
                'delete' => true,
                'custom' => [
                    [
                        'icon' => '/images/icons/crud/iconos_analisis.svg',
                        'iconType'=> 'img',
                        'iconSize'=> 'w-9',
                        'iconWidth'=> '30',
                        'class' => 'btn btn-primary btn-sm inline-flex items-center justify-center bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 p-1 rounded',
                        'title' => 'Iniciar Análisis',
                        'alpine' => [
                            'click' => [
                                'prevent' => "abrirVentana('".route('cotizacionesanalisis.create')."','?openModal=true&windowClose=false&cotizacion_solicitud_id={cotizacion_solicitud_id}&descripcion_solicitud={descripcion}')",
                            ]
                        ],
                        'condition' => [
                            'compare' => 'AND', // 'or' para condiciones OR
                            'conditions' => [
                                [
                                    'field' => 'estado_id', 
                                    'value' => 2,           
                                    'operator' => '==='
                                ],
                                [
                                    'field' => 'cotizacion_analisis_id', 
                                    'value' => null,
                                    'operator' => '==='
                                ],
                            ]
                        ],
                    ],
                    [
                        'icon' => '/images/icons/crud/iconos_ojo_abierto.svg',
                        'iconType'=> 'img',
                        'iconSize'=> 'w-9',
                        'iconWidth'=> '30',
                        'class' => 'btn btn-primary btn-sm inline-flex items-center justify-center bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 p-1 rounded',
                        'title' => 'Ver/Editar Análisis',
                        'target' => '_blank',
                        'alpine' => [
                            'click' => [
                                'prevent' => "abrirVentana(
                                                    '".route('cotizacionesanalisis.index')."',{
                                                    'modo': 'editar',
                                                    'id': {cotizacion_analisis_id},
                                                    'openModal': true
                                                }
                                            )",
                            ]
                        ],
                        'condition' => [
                            'compare' => 'AND', // 'or' para condiciones OR
                            'conditions' => [
                                [
                                    'field' => 'estado_id', 
                                    'value' => 2,
                                    'operator' => '==='
                                ],
                                [
                                    'field' => 'cotizacion_analisis_id', 
                                    'value' => null,
                                    'operator' => '!=='
                                ],
                            ]
                        ],
                    ],
                ],
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

            return $this->cotizacionesSolicitudeService->getDataTable($columns, $actionsConfig, 'cotizacionessolicitudes', 'cotizacion_solicitud_id', $filters);
        }

        return view('modules.CotizacionesSolicitudes.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo cotizacionesSolicitude.
     */
    public function store(CotizacionesSolicitudesRequest $request)
    {
        $validated = $request->validated();
        $currentUserID = Auth::guard('api')->user()->usuario_id ?? Auth::user()->usuario_id ?? 1;
        $validated['usuario_id'] = $currentUserID;

        try {
            $cotizacionesSolicitude = $this->cotizacionesSolicitudeService->create($validated);
            return response()->json([
                'success' => true,
                'message' => 'Solicitud de Cotizacion guardado exitosamente.',
                'cotizacionesSolicitude' => $cotizacionesSolicitude,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Error al guardar la Solicitud', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la Solicitud.',
            ], 500);
        }
    }

    /**
     * Muestra el cotizacionesSolicitude solicitado.
     */
    public function edit(CotizacionesSolicitudes $cotizacionessolicitude)
    {
        return response()->json($cotizacionessolicitude);
    }

    /**
     * Actualiza el cotizacionesSolicitude especificado.
     */
    public function update(CotizacionesSolicitudesRequest $request, CotizacionesSolicitudes $cotizacionessolicitude)
    {
        $validated = $request->validated();

        try {
            $this->cotizacionesSolicitudeService->update($cotizacionessolicitude, $validated);
            return response()->json([
                'success' => true,
                'message' => 'Solicitud de Cotizacion actualizada correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar la Solicitud', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar la Solicitud.',
            ], 500);
        }
    }

    /**
     * Elimina el cotizacionesSolicitude especificado.
     */
    public function destroy(CotizacionesSolicitudes $cotizacionessolicitude)
    {
        try {
            $this->cotizacionesSolicitudeService->delete($cotizacionessolicitude);
            return response()->json([
                'success' => true,
                'message' => 'Solicitud de Cotizacion eliminada correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar la Solicitud', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar la Solicitud.',
            ], 500);
        }
    }
}
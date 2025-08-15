<?php

namespace App\Services;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

use App\Models\CotizacionesAnalisis;
use App\Repositories\CotizacionesAnalisisRepository;
use App\Services\ConfiguracionesService;

class CotizacionesAnalisisService
{
    protected CotizacionesAnalisisRepository $cotizacionesanalisisRepository;
    protected ConfiguracionesService $configuracionesService;

    public function __construct(CotizacionesAnalisisRepository $cotizacionesanalisisRepository,
                                ConfiguracionesService $configuracionesService)
    {
        $this->cotizacionesanalisisRepository = $cotizacionesanalisisRepository;
        $this->configuracionesService = $configuracionesService;
    }

    /**
     * Genera la data para la DataTable.
     *
     * @param array $columns
     * @param array $actionsConfig
     * @param string $module
     * @param string $keyName
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataTable(array $columns, array $actionsConfig, string $module, string $keyName, array $filters = [])
    {
        // $query = $this->cotizacionesanalisisRepository->queryDataTable($filters);
        $query = $this->cotizacionesanalisisRepository->queryDataTableFromView($filters);

        $actionsCallback = function ($row) use ($actionsConfig, $module, $keyName) {
            return view('components.datatable-actions', compact('row', 'actionsConfig', 'module', 'keyName'))->render();
        };

        return DataTables::of($query)
            ->addColumn('action', $actionsCallback)
            ->rawColumns(['action'])
            ->filterColumn('usuario_nombre', function ($query, $keyword) {
                $query->where('usuario_nombre', 'like', "%{$keyword}%");
            })
            ->filterColumn('nombre_proyecto', function ($query, $keyword) {
                $query->where('nombre_proyecto', 'like', "%{$keyword}%");
            })
            ->filterColumn('tipo_proyecto_nombre', function ($query, $keyword) {
                $query->where('tipo_proyecto_nombre', 'like', "%{$keyword}%");
            })
            ->make(true);
    }

    /**
     * Crea un nuevo registro.
     *
     * @param array $data
     * @return CotizacionesAnalisis
     */
    public function create(array $data): CotizacionesAnalisis
    {
        try {
            return $this->cotizacionesanalisisRepository->create($data);
        } catch (\Exception $e) {
            Log::error('Error al crear registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Actualiza un registro.
     *
     * @param CotizacionesAnalisis $modelo
     * @param array $data
     * @return bool
     */
    public function update(CotizacionesAnalisis $modelo, array $data): bool
    {
        try {
            return $this->cotizacionesanalisisRepository->update($modelo, $data);
        } catch (\Exception $e) {
            Log::error('Error al actualizar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Elimina un registro.
     *
     * @param CotizacionesAnalisis $modelo
     * @return bool|null
     */
    public function delete(CotizacionesAnalisis $modelo)
    {
        try {
            return $this->cotizacionesanalisisRepository->delete($modelo);
        } catch (\Exception $e) {
            Log::error('Error al eliminar registro: ' . $e->getMessage());
            throw $e;
        }
    }

    public function obtenerDatosDocumento(int $id): array
    {
        $cotizacion = CotizacionesAnalisis::with([
            'cotizacionSolicitud.cliente',
            'cotizacionRecursos.tipoRecurso',
            'cotizacionRecursos.unidadMedida',
            'cotizacion.clienteContacto',
            'cotizacion.clienteContacto.persona',
            'cotizacion.empleadoResponsable',
            'cotizacion.empleadoResponsable.persona',
        ])->findOrFail($id);

        $cliente = $cotizacion->cotizacionSolicitud->cliente;
        $contacto = $cotizacion->cotizacion->clienteContacto;
        $contactoData = null;
        if ($contacto) {
            $contactoData = [
                'nombre' => ($contacto->persona->nombres . ' ' . $contacto->persona->apellidos),
                'cargo' => $contacto->cargo
            ];
        }
        $responsable = $cotizacion->cotizacion->empleadoResponsable;
        $responsableData = null;
        if ($responsable) {
            $responsableData = [
                'nombre' => ($responsable->persona->nombres . ' ' . $responsable->persona->apellidos),
                'cargo' => $responsable->cargo
            ];
        }
        
        // Agrupar recursos por tipo_recurso
        $agrupados = $cotizacion->cotizacionRecursos->groupBy('tipo_recurso_id')->map(function ($items) {
            $categoriaNombre = $items->first()->tipoRecurso->nombre;

            return [
                'categoria' => $categoriaNombre,
                'recursos' => $items->map(fn($r) => [
                    'clave' => $r->clave,
                    'nombre' => $r->recurso->nombre,
                    'unidad' => strtoupper($r->unidadMedida->simbolo),
                    'cantidad' => $r->cantidad,
                    'precio_unitario' => $r->precio_unitario_ganancia,
                    'subtotal' => $r->cantidad * $r->precio_unitario_ganancia,
                ])->toArray(),
                'total_categoria' => $items->sum(fn($r) => $r->precio_total),
            ];
        })->values()->toArray();

        $iva = $cotizacion->costo_subtotal * ($cotizacion->impuesto_iva / 100);
        $artwoodNombre = $this->configuracionesService->getValorCacheado('ART_NOMBRE');
        $artwoodDireccion = $this->configuracionesService->getValorCacheado('ART_DIRECCION');
        $artwoodTelefono = $this->configuracionesService->getValorCacheado('ART_TELEFONO');
        $artwoodEmail = $this->configuracionesService->getValorCacheado('ART_EMAIL');

        return [
            'cliente' => [
                'nombre' => $cliente->nombre,
                'direccion' => $cliente->direccion,
                'telefono' => $cliente->telefono,
                'email' => $cliente->email,
            ],
            'contacto'=> $contactoData,
            'responsable'=> $responsableData,
            'empresa'=> [
                'nombre'=> $artwoodNombre,
                'direccion' => $artwoodDireccion,
                'telefono'=> $artwoodTelefono,
                'email'=> $artwoodEmail
            ],
            'version' => $cotizacion->control_version,
            'fecha' => $cotizacion->cotizacion->fecha_registro->format('d/m/Y'),
            'categorias' => $agrupados,
            'iva'=> $iva,
            'subtotal' => $cotizacion->costo_subtotal,
            'total' => $cotizacion->costo_total,
            // 'total' => array_sum(array_column($agrupados, 'total_categoria')),
            'condiciones_comerciales' => $cotizacion->cotizacion->condiciones_comerciales,
            'datos_adicionales' => $cotizacion->cotizacion->datos_adicionales,
            'config' => [
                'formato' => 'Letter', // 'A4', 'Legal', Letter', etc.
                'orientacion' => 'portrait', // 'portrait' o 'landscape'
                'encabezado' => true,
                'piedepagina' => true,
            ],
        ];
    }
}
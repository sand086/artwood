<?php

namespace App\Repositories;

use App\Models\CotizacionesSolicitudes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class CotizacionesSolicitudesRepository extends BaseRepository
{
    public function __construct(CotizacionesSolicitudes $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        $query = $this->model->newQuery()
                ->select(
                    'cotizacion_solicitud_id', 'cotizacionessolicitudes.cliente_id', 'cotizacionessolicitudes.tipo_solicitud_id', 'cotizacionessolicitudes.fuente_id', 'nombre_proyecto', 'cotizacionessolicitudes.descripcion', 'fecha_estimada', 'control_version', 'cotizacionessolicitudes.usuario_id','cotizacionessolicitudes.estado_id AS estado_id', 'cotizacionessolicitudes.fecha_registro AS fecha_registro', 'cotizacionessolicitudes.fecha_actualizacion AS fecha_actualizacion', 'clientes.nombre AS cliente_nombre', 'tipossolicitudes.nombre AS tipo_solicitud_nombre', 'fuentes.nombre AS fuente_nombre', 'estadosgenerales.nombre AS estado_nombre', 'usuarios.nombre AS usuario_nombre'
                )->leftJoin('tipossolicitudes', 'cotizacionessolicitudes.tipo_solicitud_id', '=', 'tipossolicitudes.tipo_solicitud_id')
                ->leftJoin('clientes', 'cotizacionessolicitudes.cliente_id', '=', 'clientes.cliente_id')
                ->leftJoin('fuentes', 'cotizacionessolicitudes.fuente_id', '=', 'fuentes.fuente_id')
                ->leftJoin('estadosgenerales', 'cotizacionessolicitudes.estado_id', '=', 'estadosgenerales.estado_general_id')
                ->leftJoin('usuarios', 'cotizacionessolicitudes.usuario_id', '=', 'usuarios.usuario_id');

        if (!empty($filters['cotizacion_solicitud_id'])) {
            $query->where('cotizacionessolicitudes.cotizacion_solicitud_id', $filters['cotizacion_solicitud_id']);
        }

        return $query;
    }

    /**
     * Nuevo método específico para obtener la consulta del DataTable usando la vista.
     *
     * @param array $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryDataTableFromView(array $filters = []): QueryBuilder
    {
        $query = DB::table('vw_cotizacionessolicitudes');
        $query->orderBy('consecutivo', 'desc');

        // if (!empty($filters['cotizacion_solicitud_id'])) {
        //     $query->where('cotizacion_solicitud_id', $filters['cotizacion_solicitud_id']);
        // }

        return $query;
    }

    /**
     * Busca el último consecutivo registrado para un año específico.
     * @param int $year
     * @return string|null
     */
    public function findLastConsecutivoForYear(int $year): ?string
    {
        return $this->model
            ->where('consecutivo', 'like', $year . '%')
            ->orderBy('consecutivo', 'desc')
            ->value('consecutivo');
    }
}

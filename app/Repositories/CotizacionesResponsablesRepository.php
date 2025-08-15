<?php

namespace App\Repositories;

use App\Models\CotizacionesResponsables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class CotizacionesResponsablesRepository extends BaseRepository
{
    public function __construct(CotizacionesResponsables $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cotizacion_responsable_id', 'cotizacion_solicitud_id', 'persona_id', 'area_id', 'responsabilidad', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cotizacion_responsable_id', 'cotizacion_solicitud_id', 'cotizacionesresponsables.empleado_id', 'cotizacionesresponsables.area_id', 'responsabilidad', 'cotizacionesresponsables.estado AS estado', 'cotizacionesresponsables.fecha_registro AS fecha_registro', 'cotizacionesresponsables.fecha_actualizacion AS fecha_actualizacion', 'areas.nombre AS area_nombre',
                    DB::raw("CONCAT_WS(' ', personas.nombres, personas.apellidos) AS empleado_nombre_completo"),
                )->leftJoin('empleados', 'cotizacionesresponsables.empleado_id', '=', 'empleados.empleado_id')
                ->leftJoin('personas', 'empleados.persona_id', '=', 'personas.persona_id')
                ->leftJoin('areas', 'cotizacionesresponsables.area_id', '=', 'areas.area_id');

        if (!empty($filters['cotizacion_solicitud_id'])) {
            $query->where('cotizacionesresponsables.cotizacion_solicitud_id', $filters['cotizacion_solicitud_id']);
        }

        return $query;

    }

    /**
     * Nuevo método específico para obtener la consulta del DataTable usando la vista.
     * Este devolverá el Query\Builder, que es compatible con DB::table().
     *
     * @param array $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryDataTableFromView(array $filters = []): QueryBuilder
    {
        $query = DB::table('vw_cotizacionesresponsables'); // <-- Usa la vista aquí

        if (!empty($filters['cotizacion_solicitud_id'])) {
            $query->where('cotizacion_solicitud_id', $filters['cotizacion_solicitud_id']);
        }

        return $query;
    }
}

<?php

namespace App\Repositories;

use App\Models\CotizacionesAnalisis;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class CotizacionesAnalisisRepository extends BaseRepository
{
    public function __construct(CotizacionesAnalisis $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cotizacion_analisis_id', 'cotizacion_solicitud_id', 'resumen_cliente', 'resumen_solicitud', 'control_version', 'usuario_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cotizacionesanalisis.cotizacion_solicitud_id', 'cotizacionesanalisis.tipo_proyecto_id', 'cotizacion_analisis_id', 'cotizacionesanalisis.descripcion_solicitud', 'cotizacionesanalisis.tiempo_total', 'cotizacionesanalisis.costo_subtotal', 'cotizacionesanalisis.impuesto_iva', 'cotizacionesanalisis.costo_total', 'cotizacionesanalisis.control_version', 'cotizacionesanalisis.usuario_id','cotizacionesanalisis.estado', 'cotizacionesanalisis.fecha_registro AS fecha_registro', 'cotizacionesanalisis.fecha_actualizacion AS fecha_actualizacion', 'usuarios.nombre AS usuario_nombre', 'cotizacionessolicitudes.nombre_proyecto', 'tiposproyectos.nombre AS tipo_proyecto_nombre'
                )->leftJoin('cotizacionessolicitudes', 'cotizacionesanalisis.cotizacion_solicitud_id', '=', 'cotizacionessolicitudes.cotizacion_solicitud_id')
                ->leftJoin('tiposproyectos', 'cotizacionesanalisis.tipo_proyecto_id', '=', 'tiposproyectos.tipo_proyecto_id')
                ->leftJoin('usuarios', 'cotizacionesanalisis.usuario_id', '=', 'usuarios.usuario_id');

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
        $query = DB::table('vw_cotizacionesanalisis'); // <-- Usa la vista aquí

        // if (!empty($filters['cotizacion_analisis_id'])) {
        //     $query->where('cotizacion_analisis_id', $filters['cotizacion_analisis_id']);
        // }

        return $query;
    }
}

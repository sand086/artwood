<?php

namespace App\Repositories;

use App\Models\CotizacionesRecursos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class CotizacionesRecursosRepository extends BaseRepository
{
    public function __construct(CotizacionesRecursos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cotizacion_recurso_id', 'cotizacion_analisis_id', 'tipo_recurso_id', 'recurso_id', 'proveedor_id', 'unidad_medida_id', 'precio_unitario', 'cantidad', 'costo_clave', 'usuario_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cotizacion_recurso_id', 'cotizacion_analisis_id', 'cotizacionesrecursos.tipo_recurso_id', 'cotizacionesrecursos.recurso_id', 'cotizacionesrecursos.proveedor_id', 'cotizacionesrecursos.unidad_medida_id', 'cotizacionesrecursos.precio_unitario', 'cotizacionesrecursos.porcentaje_ganancia', 'precio_unitario_ganancia','cotizacionesrecursos.cantidad', 'cotizacionesrecursos.cotizacionesrecursos.tiempo_entrega', 'cotizacionesrecursos.precio_total', 'cotizacionesrecursos.usuario_id','cotizacionesrecursos.estado AS estado', 'cotizacionesrecursos.fecha_registro AS fecha_registro', 'cotizacionesrecursos.fecha_actualizacion AS fecha_actualizacion', 'tiposrecursos.nombre AS tipo_recurso_nombre', 'proveedores.nombre AS proveedor_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre', 'usuarios.nombre AS usuario_nombre',
                    DB::raw("CASE tiposrecursos.tabla_referencia
                                WHEN 'productos' THEN (SELECT nombre FROM productos WHERE productos.producto_id = cotizacionesrecursos.recurso_id LIMIT 1)
                                WHEN 'servicios' THEN (SELECT nombre FROM servicios WHERE servicios.servicio_id = cotizacionesrecursos.recurso_id LIMIT 1)
                                WHEN 'materiales' THEN (SELECT nombre FROM materiales WHERE materiales.material_id = cotizacionesrecursos.recurso_id LIMIT 1)
                                WHEN 'equipos' THEN (SELECT nombre FROM equipos WHERE equipos.equipo_id = cotizacionesrecursos.recurso_id LIMIT 1)
                                WHEN 'gastos' THEN (SELECT nombre FROM gastos WHERE gastos.gasto_id = cotizacionesrecursos.recurso_id LIMIT 1)
                                ELSE NULL
                            END AS recurso_nombre")
                )->leftJoin('tiposrecursos', 'cotizacionesrecursos.tipo_recurso_id', '=', 'tiposrecursos.tipo_recurso_id')
                ->leftJoin('proveedores', 'cotizacionesrecursos.proveedor_id', '=', 'proveedores.proveedor_id')
                ->leftJoin('unidadesmedidas', 'cotizacionesrecursos.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id')
                ->leftJoin('usuarios', 'cotizacionesrecursos.usuario_id', '=', 'usuarios.usuario_id');

        if (!empty($filters['cotizacion_analisis_id'])) {
            $query->where('cotizacionesrecursos.cotizacion_analisis_id', $filters['cotizacion_analisis_id']);
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
        $query = DB::table('vw_cotizacionesrecursos'); // <-- Usa la vista aquí

        if (!empty($filters['cotizacion_analisis_id'])) {
            $query->where('cotizacion_analisis_id', $filters['cotizacion_analisis_id']);
        }

        return $query;
    }
}

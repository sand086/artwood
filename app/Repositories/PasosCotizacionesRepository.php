<?php

namespace App\Repositories;

use App\Models\PasosCotizaciones;
use Illuminate\Database\Eloquent\Builder;

class PasosCotizacionesRepository extends BaseRepository
{
    public function __construct(PasosCotizaciones $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('paso_cotizacion_id', 'nombre', 'descripcion', 'tipo_cliente_id', 'orden', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'paso_cotizacion_id', 'pasoscotizaciones.nombre AS nombre', 'pasoscotizaciones.descripcion', 'pasoscotizaciones.tipo_cliente_id', 'orden', 'pasoscotizaciones.estado AS estado', 'pasoscotizaciones.fecha_registro AS fecha_registro', 'pasoscotizaciones.fecha_actualizacion AS fecha_actualizacion',
                    'tiposclientes.nombre AS tipo_cliente_nombre', 
                )->leftJoin('tiposclientes', 'pasoscotizaciones.tipo_cliente_id', '=', 'tiposclientes.tipo_cliente_id');

        if (!empty($filters['proveedor_id'])) {
            $query->where('proveedoresproductos.proveedor_id', $filters['proveedor_id']);
        }

        return $query;

    }
}

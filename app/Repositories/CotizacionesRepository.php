<?php

namespace App\Repositories;

use App\Models\Cotizaciones;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CotizacionesRepository extends BaseRepository
{
    public function __construct(Cotizaciones $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cotizacion_id', 'cotizacion_solicitud_id', 'cliente_contacto_id', 'plantilla_id', 'condiciones_comerciales', 'datos_adicionales', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cotizacion_id', 'cotizaciones.cotizacion_solicitud_id', 'cotizaciones.cliente_contacto_id', 'cotizaciones.empleado_responsable_id', 'cotizaciones.plantilla_id', 'cotizaciones.control_version', 'condiciones_comerciales', 'datos_adicionales', 'cotizaciones.estado AS estado', 'cotizaciones.fecha_registro AS fecha_registro', 'cotizaciones.fecha_actualizacion AS fecha_actualizacion', 'plantillas.nombre AS plantilla_nombre',
                    'cotizacionessolicitudes.consecutivo',
                    DB::raw("CONCAT_WS(' ', personas.nombres, personas.apellidos) AS contacto_nombre_completo"),
                )
                ->leftJoin('cotizacionessolicitudes', 'cotizaciones.cotizacion_solicitud_id', '=', 'cotizacionessolicitudes.cotizacion_solicitud_id')
                ->leftJoin('clientescontactos', 'cotizaciones.cliente_contacto_id', '=', 'clientescontactos.cliente_contacto_id')
                ->leftJoin('personas', 'clientescontactos.persona_id', '=', 'personas.persona_id')
                ->leftJoin('plantillas', 'cotizaciones.plantilla_id', '=', 'plantillas.plantilla_id');

        // if (!empty($filters['cotizacion_id'])) {
        //     $query->where('cotizaciones.cotizacion_id', $filters['cotizacion_id']);
        // }

        return $query;

    }
}

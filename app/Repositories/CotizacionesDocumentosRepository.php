<?php

namespace App\Repositories;

use App\Models\CotizacionesDocumentos;
use Illuminate\Database\Eloquent\Builder;

class CotizacionesDocumentosRepository extends BaseRepository
{
    public function __construct(CotizacionesDocumentos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cotizacion_documento_id', 'cotizacion_solicitud_id', 'nombre_documento_original', 'nombre_documento_sistema', 'descripcion', 'ruta_almacenamiento', 'tipo_mime', 'tamano_bytes', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cotizacion_documento_id', 'cotizacion_solicitud_id', 'nombre_documento_original', 'nombre_documento_sistema', 'descripcion', 'ruta_almacenamiento', 'tipo_mime', 'tamano_bytes', 'cotizacionesdocumentos.estado AS estado', 'cotizacionesdocumentos.fecha_registro AS fecha_registro', 'cotizacionesdocumentos.fecha_actualizacion AS fecha_actualizacion',
                );
                // ->leftJoin('personas', 'empleados.persona_id', '=', 'personas.persona_id')
                // ->leftJoin('areas', 'cotizacionesdocumentos.area_id', '=', 'areas.area_id');

        if (!empty($filters['cotizacion_solicitud_id'])) {
            $query->where('cotizacionesdocumentos.cotizacion_solicitud_id', $filters['cotizacion_solicitud_id']);
        }

        return $query;
    }
}

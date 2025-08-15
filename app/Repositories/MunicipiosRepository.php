<?php

namespace App\Repositories;

use App\Models\Municipios;
use Illuminate\Database\Eloquent\Builder;

class MunicipiosRepository extends BaseRepository
{
    public function __construct(Municipios $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        // return $this->model->select('municipio_id', 'nombre', 'codigo_postal', 'estado_pais_id', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'municipio_id', 'municipios.nombre AS nombre', 'municipios.codigo_postal', 'municipios.estado_pais_id', 'municipios.estado AS estado', 'municipios.fecha_registro AS fecha_registro', 'municipios.fecha_actualizacion AS fecha_actualizacion',
                    'estadospaises.nombre AS estado_pais_nombre'
                )->leftJoin('estadospaises', 'municipios.estado_pais_id', '=', 'estadospaises.estado_pais_id');

        return $query;
    }
}
<?php

namespace App\Repositories;

use App\Models\Configuraciones;
use Illuminate\Database\Eloquent\Builder;

class ConfiguracionesRepository extends BaseRepository
{
    public function __construct(Configuraciones $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->select('configuracion_id', 'nombre', 'clave', 'valor', 'tipo_dato', 'fecha_inicio_vigencia', 'fecha_fin_vigencia', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');
        return $this->model->newQuery()->select('configuracion_id', 'nombre', 'clave', 'valor', 'tipo_dato', 'fecha_inicio_vigencia', 'fecha_fin_vigencia', 'descripcion', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}

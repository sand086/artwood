<?php

namespace App\Repositories;

use App\Models\Plantillas;
use Illuminate\Database\Eloquent\Builder;

class PlantillasRepository extends BaseRepository
{
    public function __construct(Plantillas $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        return $this->model->newQuery()->select('plantilla_id', 'nombre', 'clave', 'tipo', 'modulo', 'formato', 'origen_datos', 'fuente_datos', 'html', 'estado', 'fecha_registro', 'fecha_actualizacion');

    }
}

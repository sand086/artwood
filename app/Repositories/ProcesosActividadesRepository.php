<?php

namespace App\Repositories;

use App\Models\ProcesosActividades;
use Illuminate\Database\Eloquent\Builder;

class ProcesosActividadesRepository extends BaseRepository
{
    public function __construct(ProcesosActividades $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // Aquí puedes agregar la lógica para construir la consulta base
        $query = $this->model->newQuery()
                ->select(
                    'proceso_actividad_id', 'procesosactividades.nombre AS nombre', 'procesosactividades.descripcion AS descripcion', 'procesos.proceso_id AS persona_id', 'tiempo_estimado', 'costo_estimado', 'riesgos', 'observaciones', 'procesosactividades.estado AS estado', 'procesosactividades.fecha_registro AS fecha_registro', 'procesosactividades.fecha_actualizacion AS fecha_actualizacion',
                    'procesos.nombre AS proceso_nombre', 'areas.nombre AS area_nombre', 'unidadesmedidas.nombre AS unidad_medida_nombre'
                )->leftJoin('procesos', 'procesosactividades.proceso_id', '=', 'procesos.proceso_id')
                ->leftJoin('areas', 'procesosactividades.area_id', '=', 'areas.area_id')
                ->leftJoin('unidadesmedidas', 'procesosactividades.unidad_medida_id', '=', 'unidadesmedidas.unidad_medida_id');

        if (!empty($filters['proceso_id'])) {
            $query->where('procesosactividades.proceso_id', $filters['proceso_id']); // Asegúrate de prefijar si haces joins
        }

        return $query;

    }
}

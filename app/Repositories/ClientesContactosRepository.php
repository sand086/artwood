<?php

namespace App\Repositories;

use App\Models\ClientesContactos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;

class ClientesContactosRepository extends BaseRepository
{
    public function __construct(ClientesContactos $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(array $filters = []): Builder
    {
        // return $this->model->newQuery()->select('cliente_contacto_id', 'cliente_id', 'persona_id', 'cargo', 'telefono', 'correo_electronico', 'observaciones', 'estado', 'fecha_registro', 'fecha_actualizacion');

        $query = $this->model->newQuery()
                ->select(
                    'cliente_contacto_id', 'clientescontactos.cliente_id', 'clientescontactos.persona_id AS persona_id', 'cargo', 'clientescontactos.telefono AS telefono', 'clientescontactos.correo_electronico', 'observaciones', 'clientescontactos.estado AS estado', 'clientescontactos.fecha_registro AS fecha_registro', 'clientescontactos.fecha_actualizacion AS fecha_actualizacion',
                    DB::raw("CONCAT_WS(' ', personas.nombres, personas.apellidos) AS contacto_nombre_completo")
                )->leftJoin('clientes', 'clientescontactos.cliente_id', '=', 'clientes.cliente_id')
                ->leftJoin('personas', 'clientescontactos.persona_id', '=', 'personas.persona_id');

        if (!empty($filters['cliente_id'])) {
            $query->where('clientescontactos.cliente_id', $filters['cliente_id']); // Asegúrate de prefijar si haces joins
        }

        return $query;
    }

    /**
     * Nuevo método específico para obtener la consulta del DataTable usando la vista.
     *
     * @param array $filters
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryDataTableFromView(array $filters = []): QueryBuilder
    {
        $query = DB::table('vw_clientescontactos'); // <-- Usa la vista aquí

        if (!empty($filters['cliente_id'])) {
            $query->where('cliente_id', $filters['cliente_id']);
        }

        return $query;
    }
}

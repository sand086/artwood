<?php

namespace App\Repositories;

use App\Models\Usuarios;
use Illuminate\Database\Eloquent\Builder;

class UsuariosRepository extends BaseRepository
{
    public function __construct(Usuarios $model)
    {
        parent::__construct($model);
    }

    public function queryDataTable(): Builder
    {
        return $this->model->newQuery()
            ->leftJoin('roles', 'usuarios.role_id', '=', 'roles.role_id')
            ->leftJoin('personas', 'usuarios.persona_id', '=', 'personas.persona_id')
            ->select(
                'usuarios.usuario_id',
                'usuarios.nombre',
                'usuarios.contrasena',
                'usuarios.fecha_ultimo_acceso',
                'usuarios.metodo_doble_factor',
                'usuarios.doble_factor',
                'usuarios.no_intentos',
                'usuarios.role_id',
                'roles.name as role_nombre',
                'usuarios.persona_id',
                'personas.nombres as persona_nombres',
                'personas.apellidos as persona_apellidos',
                'personas.correo_electronico as email', // Agrega el campo email
                'usuarios.IP',
                'usuarios.estado'
            );
    }
}

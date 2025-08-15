<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Models\Role as SpatieRole;

class Roles extends SpatieRole
{
    use HasFactory;

    protected $table = 'roles';
    protected $primaryKey = 'role_id'; // Clave primaria personalizada
    public $incrementing = true; // Asegúrate de que coincide con tu columna
    protected $keyType = 'int';

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * Sobrescribe getKeyName para que Eloquent use 'role_id' en lugar de 'id'
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return $this->primaryKey;
    }


    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'descripcion',
        'guard_name',
        'descripcion',
        'estado',
    ];

    /**
     * Los atributos que no son asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
        'role_id',
        'estado',
        'fecha_registro',
        'fecha_actualizacion'
    ];


    /**
     * Relación de permisos personalizada para Spatie.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(
            config('permission.models.permission'),
            config('permission.table_names.role_has_permissions'),
            'role_id',       // Clave foránea en la tabla pivot para este modelo (roles)
            'permission_id', // Clave foránea para el modelo relacionado (permissions)
            'role_id',       // Clave local en el modelo Roles
            'permission_id'  // Clave local en el modelo Permissions
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Spatie\Permission\Traits\HasRoles;


class Usuarios extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';

    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    protected $fillable = [
        'nombre',
        'contrasena',
        'fecha_ultimo_acceso',
        'metodo_doble_factor',
        'doble_factor',
        'no_intentos',
        'role_id',
        'persona_id',
        'IP',
        'estado'
    ];

    protected $casts = [
        'fecha_ultimo_acceso' => 'datetime',
        'no_intentos' => 'integer',
        'estado' => 'string',
    ];

    protected $guarded = ['usuario_id'];

    // Relación: Un usuario pertenece a un rol
    public function rol()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'role_id');
    }

    // Relación: Un usuario pertenece a una persona
    public function persona()
    {
        return $this->belongsTo(Personas::class, 'persona_id', 'persona_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    public function getRouteKeyName()
    {
        return 'usuario_id';
    }
}

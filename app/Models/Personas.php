<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'personas';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'persona_id'; // Clave primaria personalizada

    /**
     * Redefinicion de las fechas constantes CREATED_AT y UPDATED_AT.
     *
     * @const string
     * @const string
     */
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [

        'nombres',
        'apellidos',
        'direccion',
        'telefono',
        'correo_electronico',
        'estado_pais_id',
        'municipio_id',
        'colonia',
        'tipo_identificacion_id',
        'identificador',
        'estado'

    ];

    /**
     * Los atributos que no son asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [

        'persona_id', 'fecha_registro', 'fecha_actualizacion'

    ];

    /**
     * Accesor para obtener el nombre completo de la persona.
     */
    public function getNombreCompletoAttribute()
    {
        $nombreCompleto = trim(($this->nombres ?? '') . ' ' . ($this->apellidos ?? ''));
        return $nombreCompleto ?: null; // Devuelve null si ambos nombres y apellidos están vacíos o no existen
    }
    /*

    public function getRouteKeyName()
    {
        return 'persona_id';
    }*/
}

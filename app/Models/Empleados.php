<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'empleados';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'empleado_id'; // Clave primaria personalizada

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
        'persona_id', 'cargo', 'usuario_id', 'estado'
    ];

    /**
     * Los atributos que no son asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
      'empleado_id', 'estado', 'fecha_registro', 'fecha_actualizacion'
    ];

    /**
     * Obtiene la persona asociada con el empleado.
     * 
     * @return BelongsTo
     */
    public function persona()
    {
        return $this->belongsTo(Personas::class, 'persona_id');
    }

    /**
     * Obtiene el nombre completo del empleado desde la tabla personas.
     *
     * @return string
     */
    public function getNombreCompletoAttribute(): string
    {
        // Accede a la relación 'persona' y concatena los campos
        if ($this->persona) {
            return trim(($this->persona->nombres ?? '') . ' ' . ($this->persona->apellidos ?? ''));
        }
        return 'Empleado sin persona asignada'; // O alguna indicación
    }

    // Ejemplo: Relación muchos a muchos con la tabla 'etiquetas'
    /*
    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class);
    }
    */

    
    /*
    public function getRouteKeyName()
    {
        return 'slug';
    }
    */
}
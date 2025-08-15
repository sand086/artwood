<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantillas extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'plantillas';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'plantilla_id'; // Clave primaria personalizada

    /**
     * Redefinición de las fechas constantes CREATED_AT y UPDATED_AT.
     *
     * @const string
     * @const string
     */
    const CREATED_AT = 'fecha_registro';
    const UPDATED_AT = 'fecha_actualizacion';

    /**
     * Los atributos asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        // Aquí agregar los campos que son asignables
        'nombre',
        'clave',
        'tipo',
        'modulo',
        'formato',
        'origen_datos',
        'fuente_datos',
        'html',
    ];

    /**
     * Los atributos no asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
      // Aquí agregar los campos
    ];

    // Opcional: definir relaciones
}

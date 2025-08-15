<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionesSolicitudes extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'cotizacionessolicitudes';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'cotizacion_solicitud_id'; // Clave primaria personalizada

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
        'tipo_solicitud_id', 'cliente_id', 'fuente_id', 'consecutivo', 'nombre_proyecto', 'descripcion', 'fecha_estimada', 'control_version', 'usuario_id', 'estado_id'
    ];

    /**
     * Los atributos no asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
      'cotizacion_solicitud_id', 'fecha_creacion', 'fecha_actualizacion'
    ];

    /**
     * Relación con el modelo Clientes.
     *
     * @return Clientes
     */
    public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }
    // Opcional: definir relaciones
}

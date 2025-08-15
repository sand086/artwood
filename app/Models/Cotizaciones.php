<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizaciones extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'cotizaciones';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'cotizacion_id'; // Clave primaria personalizada

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
        'cotizacion_solicitud_id',
        'cliente_contacto_id',
        'empleado_responsable_id',
        'plantilla_id',
        'control_version',
        'condiciones_comerciales',
        'datos_adicionales',
        'estado',
    ];

    /**
     * Los atributos no asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
      // Aquí agregar los campos
      'cotizacion_id',
      'cotizacion_solicitud_id',
      'cliente_contacto_id',
      'empleado_responsable_id',
      'plantilla_id',
      'control_version',
      'fecha_registro',
      'fecha_actualizacion'
    ];

    public function cotizacionSolicitud()
    {
      return $this->belongsTo(CotizacionesSolicitudes::class,'cotizacion_solicitud_id','cotizacion_solicitud_id');
    }

    public function clienteContacto()
    {
      return $this->belongsTo(ClientesContactos::class,'cliente_contacto_id','cliente_contacto_id');
    }

    public function empleadoResponsable()
    {
      return $this->belongsTo(Empleados::class,'empleado_responsable_id','empleado_id');
    }

    public function plantilla()
    {
      return $this->belongsTo(Plantillas::class,'plantilla_id','plantilla_id');
    }

    // Opcional: definir relaciones
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\MonedaHelper;

class CotizacionesAnalisis extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'cotizacionesanalisis';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'cotizacion_analisis_id'; // Clave primaria personalizada

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
        'tipo_proyecto_id',
        'descripcion_solicitud',
        'tiempo_total',
        'impuesto_iva',
        'costo_subtotal',
        'costo_total',
        'usuario_id',
        'estado',
    ];

    /**
     * Los atributos no asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
      // Aquí agregar los campos
    ];

    /**
     * Accesor para el atributo 'costo_subtotal'.
     * Formatea el costo subtotal para visualización cuando se accede al modelo.
     *
     * @param string|float $value
     * @return string
     */
    // public function getCostoSubtotalAttribute($value): string
    // {
    //     return MonedaHelper::formatearMoneda($value);
    // }

    /**
     * Mutador para el atributo 'costo_subtotal'.
     * Desformatea el costo subtotal para guardar en la base de datos.
     *
     * @param string $value
     * @return void
     */
    public function setCostoSubtotalAttribute(string $value): void
    {
        $this->attributes['costo_subtotal'] = MonedaHelper::desformatearMoneda($value);
    }

    /**
     * Accesor para el atributo 'costo_total'.
     * Formatea el costo total para visualización cuando se accede al modelo.
     *
     * @param string|float $value
     * @return string
     */
    // public function getCostoTotalAttribute($value): string
    // {
    //     return MonedaHelper::formatearMoneda($value);
    // }

    /**
     * Mutador para el atributo 'costo_total'.
     * Desformatea el costo total para guardar en la base de datos.
     *
     * @param string $value
     * @return void
     */
    public function setCostoTotalAttribute(string $value): void
    {
        $this->attributes['costo_total'] = MonedaHelper::desformatearMoneda($value);
    }

    /**
     * Relación con el modelo CotizacionesSolicitudes.
     *
     * @return CotizacionesSolicitudes
     */
    public function cotizacionSolicitud()
    {
        return $this->belongsTo(CotizacionesSolicitudes::class, 'cotizacion_solicitud_id');
    }

    /**
     * Relación con el modelo CotizacionesRecursos.
     *
     * @return CotizacionesRecursos
     */
    public function cotizacionRecursos()
    {
        return $this->hasMany(CotizacionesRecursos::class, 'cotizacion_analisis_id', 'cotizacion_analisis_id');
    }

    // En el modelo CotizacionesAnalisis.php
    public function cotizacion()
    {
        // Asumiendo que el campo cotizacion_solicitud_id en la tabla cotizaciones
        // es la clave foránea para la relación.
        return $this->hasOne(Cotizaciones::class, 'cotizacion_solicitud_id', 'cotizacion_solicitud_id');
    }
    // Si tienes más campos de dinero, repite el patrón:
    // public function getTotalAttribute($value): string
    // {
    //     return NumberHelper::formatearDineroParaMostrar($value);
    // }

    // Opcional: definir relaciones
}

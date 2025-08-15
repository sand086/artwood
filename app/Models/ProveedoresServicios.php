<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProveedoresServicios extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'proveedoresservicios';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'proveedor_servicio_id'; // Clave primaria personalizada

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
        'proveedor_id',
        'servicio_id',
        'descripcion',
        'tiempo',
        'unidad_medida_id',
        'precio_unitario',
        'detalle',
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

    // Opcional: definir relaciones
}

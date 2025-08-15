<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\MonedaHelper;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CotizacionesRecursos extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'cotizacionesrecursos';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'cotizacion_recurso_id'; // Clave primaria personalizada

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
        'cotizacion_analisis_id',
        'tipo_recurso_id',
        'recurso_id',
        'proveedor_id',
        'unidad_medida_id',
        'precio_unitario',
        'porcentaje_ganancia',
        'precio_unitario_ganancia',
        'cantidad',
        'precio_total',
        'tiempo_entrega',
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
     * Mutador para el atributo 'precio_unitario'.
     * Desformatea el precio unitario para guardar en la base de datos.
     *
     * @param string $value
     * @return void
     */
    // public function setPrecioUnitarioAttribute(string $value): void
    // {
    //     $this->attributes['precio_unitario'] = MonedaHelper::desformatearMoneda($value);
    // }

    /**
     * Mutador para el atributo 'precio_total'.
     * Desformatea el precio total para guardar en la base de datos.
     *
     * @param string $value
     * @return void
     */
    // public function setPrecioTotalAttribute(string $value): void
    // {
    //     $this->attributes['precio_total'] = MonedaHelper::desformatearMoneda($value);
    // }

    public function tipoRecurso()
    {
        return $this->belongsTo(TiposRecursos::class, 'tipo_recurso_id', 'tipo_recurso_id');
    }

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadesMedidas::class, 'unidad_medida_id', 'unidad_medida_id');
    }

    // Método para obtener el recurso dinámicamente
    public function getRecursoAttribute()
    {
        // Asegúrate de que tipoRecurso esté cargado
        if (!$this->relationLoaded('tipoRecurso')) {
            $this->load('tipoRecurso');
        }

        $modelo = 'App\\Models\\' . ucfirst($this->tipoRecurso->tabla_referencia);
        
        // El tipo de recurso no existe en el proyecto
        if (!class_exists($modelo)) {
            return null;
        }

        return $modelo::find($this->recurso_id);
    }
    
    // Opcional: definir relaciones
}

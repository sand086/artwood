<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadosPaises extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'estadospaises';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'estado_pais_id'; // Clave primaria personalizada

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
        'nombre', 'pais_id', 'estado'
    ];

    /**
     * Los atributos que no son asignables masivamente.
     *
     * @var array
     */
    protected $guarded = [
      'estado_pais_id', 'estado', 'fecha_registro', 'fecha_actualizacion'
    ];

    

    // Ejemplo: Relación uno a muchos con la tabla 'categorias'
    /*
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    */

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
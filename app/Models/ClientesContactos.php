<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientesContactos extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'clientescontactos';

    /**
     * La clave primaria asociada con el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'cliente_contacto_id'; // Clave primaria personalizada

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
        'cliente_id',
        'persona_id',
        'cargo',
        'telefono',
        'correo_electronico',
        'observaciones',
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

    public function cliente()
    {
      return $this->belongsTo(Clientes::class,'cliente_id','cliente_id');
    }

    public function persona()
    {
      return $this->belongsTo(Personas::class,'persona_id','persona_id');
    }
    // Opcional: definir relaciones
}

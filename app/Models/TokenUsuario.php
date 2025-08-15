<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenUsuario extends Model
{
    use HasFactory;

    protected $table = 'tokens_usuarios'; // Nombre de la tabla
    protected $primaryKey = 'token_usuario_id'; // Clave primaria
    public $timestamps = false; // Deshabilitar timestamps automáticos

    protected $fillable = [
        'usuario_id',
        'token',
        'estado',
    ];

    protected $casts = [
        'fecha_registro' => 'datetime',
        'fecha_actualizacion' => 'datetime',
    ];

    /**
     * Relación con el modelo Usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'usuario_id', 'usuario_id');
    }
}

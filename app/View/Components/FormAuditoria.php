<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Carbon\Carbon;

class FormAuditoria extends Component
{
    public $estado;
    public $estadoTexto;
    public $fechaRegistro;
    public $fechaActualizacion;

    public function __construct($estado = 'A', $fechaRegistro = null, $fechaActualizacion = null)
    {
        $this->estado      = $estado;
        $this->estadoTexto = $this->getEstadoTexto($estado);

        // formateo amigable: día/mes/año hora:minutos (24h)
        $format = 'd/m/Y H:i';

        $this->fechaRegistro     = $fechaRegistro
            ? Carbon::parse($fechaRegistro)->format($format)
            : Carbon::now()->format($format);

        $this->fechaActualizacion = $fechaActualizacion
            ? Carbon::parse($fechaActualizacion)->format($format)
            : Carbon::now()->format($format);
    }

    private function getEstadoTexto($estado)
    {
        return match ($estado) {
            'A' => 'ACTIVO',
            'I' => 'INACTIVO',
            'E' => 'ELIMINADO',
            default => '',
        };
    }

    public function render()
    {
        return view('components.form-auditoria');
    }
}

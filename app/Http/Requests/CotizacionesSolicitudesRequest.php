<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesSolicitudesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // O tu lógica de autorización
    }

    public function rules(): array
    {
        if ($this->boolean('only_status')) {
            return [
                'estado' => 'required|in:A,I,E',
            ];
        }
        return [
            'tipo_solicitud_id' => 'required',
            'cliente_id' => 'required',
            'fuente_id' => 'required',
            'nombre_proyecto' => 'required',
            'descripcion' => 'required',
            'fecha_estimada' => 'required',
            'control_version' => 'required',
            'estado_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'tipo_solicitud_id.required' => 'El dato tipo de solicitud es requerido.',
            'cliente_id.required' => 'El dato cliente es requerido.',
            'fuente_id.required' => 'El dato fuente es requerido.',
            'nombre_proyecto.required' => 'El dato Nombre Proyecto es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'fecha_estimada.required' => 'El dato Fecha Estimada es requerido.',
            'control_version.required' => 'El dato Control Version es requerido.'
        ];
    }
}
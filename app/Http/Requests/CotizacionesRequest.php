<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // O tu lógica de autorización
    }

    public function rules(): array
    {
        return [
            'cotizacion_solicitud_id' => 'required',
            'cliente_contacto_id' => 'nullable',
            'empleado_responsable_id' => 'nullable',
            'plantilla_id' => 'required',
            'control_version' => 'nullable',
            'condiciones_comerciales' => 'nullable',
            'datos_adicionales' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'cotizacion_solicitud_id.required' => 'El dato Solicitud es requerido.',
            // 'cliente_contacto_id.required' => 'El dato Contacto Destinatario es requerido.',
            'plantilla_id.required' => 'El dato Plantilla es requerida.',
            // 'condiciones_comerciales.required' => 'El dato condiciones_comerciales es requerido.',
            // 'datos_adicionales.required' => 'El dato datos_adicionales es requerido.'
        ];
    }
}
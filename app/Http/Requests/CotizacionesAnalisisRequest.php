<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesAnalisisRequest extends FormRequest
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
            'cotizacion_solicitud_id' => 'required',
            'tipo_proyecto_id' => 'required',
            'descripcion_solicitud' => 'required',
            'tiempo_total' => 'required',
            'costo_subtotal' => 'required',
            'impuesto_iva' => 'required',
            'costo_total' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'cotizacion_solicitud_id.required' => 'El dato Solicitud de la Cotización es requerido.',
            'tipo_proyecto_id.required' => 'El dato tipo de proyecto es requerido.',
            'descripcion_solicitud.required' => 'El dato descripcion de la solicitud es requerido.',
            'tiempo_total.required' => 'El dato tiempo total es requerido.',
            'costo_subtotal.required' => 'El dato costo subtotal es requerido.',
            'impuesto_iva.required' => 'El dato impuesto de IVA es requerido.',
            'costo_total.required' => 'El dato costo total es requerido.'
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesResponsablesRequest extends FormRequest
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
            'empleado_id' => 'required',
            'area_id' => 'required',
            'responsabilidad' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'empleado_id.required' => 'El dato empleado es requerido.',
            'area_id.required' => 'El dato area es requerido.',
            'responsabilidad.required' => 'El dato responsabilidad es requerido.'
        ];
    }
}
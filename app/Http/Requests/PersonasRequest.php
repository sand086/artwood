<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonasRequest extends FormRequest
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
            'nombres' => 'required',
            'apellidos' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'correo_electronico' => 'required',
            'tipo_identificacion_id' => 'required',
            'identificador' => 'required_unless:tipo_identificacion_id,1', // tipo de identificacion 1 = "Sin Identificacion"
            'estado_pais_id' => 'nullable',
            'municipio_id' => 'nullable',
            'colonia' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'nombres.required' => 'El dato nombres es requerido.',
            'apellidos.required' => 'El dato apellidos es requerido.',
            'direccion.required' => 'El dato direcci&oacute;n es requerido.',
            'telefono.required' => 'El dato tel&eacute;fono es requerido.',
            'correo_electronico.required' => 'El dato correo electr&oacute;nico es requerido.',
            'tipo_identificacion_id.required' => 'El dato tipo identificaci&oacute;n es requerido.',
            'identificador.required' => 'El dato identificador es requerido.'
        ];
    }
}
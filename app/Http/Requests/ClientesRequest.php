<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class ClientesRequest extends FormRequest
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
            'nombre' => 'required',
            'tipo_cliente_id' => 'required',
            'clase' => ['required', Rule::in(['CLIENTE', 'PROSPECTO'])],
            'rfc' => 'nullable',
            'direccion' => 'required',
            'codigo_postal' => 'nullable',
            'colonia' => 'nullable',
            'municipio_id' => 'required',
            'estado_pais_id' => 'required',
            'telefono' => 'required',
            'sitio_web' => 'nullable',
            'notas_adicionales' => 'nullable',
            // 'usuario_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'tipo_cliente_id.required' => 'El dato tipo es requerido.',
            'clase.required' => 'El dato clase es requerido.',
            'clase.in' => 'El valor seleccionado para clase no es válido.',
            'direccion.required' => 'El dato direccion es requerido.',
            // 'colonia_id.required' => 'El dato colonia_id es requerido.',
            'municipio_id.required' => 'El dato municipio_id es requerido.',
            'estado_pais_id.required' => 'El dato estado_pais_id es requerido.',
            'telefono.required' => 'El dato telefono es requerido.',
            'sitio_web.nullable' => 'El dato sitio_web es opcional'
            // 'sitio_web.required' => 'El dato sitio_web es requerido.',
            // 'notas_adicionales.required' => 'El dato notas_adicionales es requerido.',
            // 'usuario_id.required' => 'El dato usuario_id es requerido.'
        ];
    }
}
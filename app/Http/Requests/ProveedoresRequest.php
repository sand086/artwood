<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedoresRequest extends FormRequest
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
            'tipo' => 'required',
            'rfc' => 'required|max:16',
            'direccion' => 'required',
            'codigo_postal' => 'string|max:8',
            'telefono' => 'required',
            'colonia' => 'nullable',
            'municipio_id' => 'nullable',
            'estado_pais_id' => 'nullable',
            'codigo_postal' => 'nullable',
            'sitio_web' => 'nullable',
            'notas_adicionales' => 'nullable',
            'usuario_id' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'tipo.required' => 'El dato tipo es requerido.',
            'direccion.required' => 'El dato direccion es requerido.',
            'telefono.required' => 'El dato telefono es requerido.',
            'rfc.required' => 'El dato RFC es requerido.',
        ];
    }
}
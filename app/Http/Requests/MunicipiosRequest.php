<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MunicipiosRequest extends FormRequest
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
            'codigo_postal' => 'required',
            'estado_pais_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'codigo_postal.required' => 'El dato codigo_postal es requerido.',
            'estado_pais_id.required' => 'El dato estado_pais_id es requerido.'
        ];
    }
}
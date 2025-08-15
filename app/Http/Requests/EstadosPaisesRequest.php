<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadosPaisesRequest extends FormRequest
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
            'pais_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'pais_id.required' => 'El dato pais_id es requerido.'
        ];
    }
}
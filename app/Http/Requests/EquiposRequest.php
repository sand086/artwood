<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquiposRequest extends FormRequest
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
            'descripcion' => 'required',
            'unidad_medida_id' => 'required',
            'precio_unitario' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'unidad_medida_id.required' => 'El dato unidad_medida_id es requerido.',
            'precio_unitario.required' => 'El dato precio_unitario es requerido.'
        ];
    }
}
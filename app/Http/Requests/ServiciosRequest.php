<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiciosRequest extends FormRequest
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
            'tiempo' => 'required',
            'unidad_medida_id' => 'required',
            'precio' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'tiempo.required' => 'El dato tiempo es requerido.',
            'unidad_medida_id.required' => 'El dato unidad medida es requerido.',
            'precio.required' => 'El dato precio es requerido.'
        ];
    }
}
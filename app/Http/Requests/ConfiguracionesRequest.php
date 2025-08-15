<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfiguracionesRequest extends FormRequest
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
            'clave' => 'required',
            'valor' => 'required',
            'tipo_dato' => 'required',
            'fecha_inicio_vigencia' => 'required',
            'fecha_fin_vigencia' => 'nullable|date',
            'descripcion' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'clave.required' => 'El dato clave es requerido.',
            'valor.required' => 'El dato valor es requerido.',
            'tipo_dato.required' => 'El dato tipo_dato es requerido.',
            'fecha_inicio_vigencia.required' => 'El dato fecha_inicio_vigencia es requerido.',
            // 'fecha_fin_vigencia.required' => 'El dato fecha_fin_vigencia es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.'
        ];
    }
}
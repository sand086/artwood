<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GastosRequest extends FormRequest
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
            'tipo_gasto_id' => 'required',
            'unidad_medida_id' => 'required',
            'valor_unidad' => 'required',
            'cantidad' => 'required',
            'valor_total' => 'required',
            // 'usuario_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'tipo_gasto_id.required' => 'El dato tipo_gasto_id es requerido.',
            'unidad_medida_id.required' => 'El dato unidad_medida_id es requerido.',
            'valor_unidad.required' => 'El dato valor_unidad es requerido.',
            'cantidad.required' => 'El dato cantidad es requerido.',
            'valor_total.required' => 'El dato valor_total es requerido.',
            // 'usuario_id.required' => 'El dato usuario_id es requerido.'
        ];
    }
}
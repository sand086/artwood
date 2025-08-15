<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasosCotizacionesRequest extends FormRequest
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
            'tipo_cliente_id' => 'required',
            'orden' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'tipo_cliente_id.required' => 'El dato tipo_cliente_id es requerido.',
            'orden.required' => 'El dato orden es requerido.'
        ];
    }
}
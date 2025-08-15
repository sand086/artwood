<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedoresServiciosRequest extends FormRequest
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
            'proveedor_id' => 'required',
            'servicio_id' => 'required',
            'descripcion' => 'required',
            'tiempo'=> 'required',
            'unidad_medida_id'=> 'required',
            'precio_unitario'=> 'required', 
            'detalle' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor_id.required' => 'El dato proveedor_id es requerido.',
            'servicio_id.required' => 'El dato servicio_id es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'tiempo.required' => 'El dato tiempo es requerido.',
            'unidad_medida_id.required' => 'El dato unidad de medida es requerido.',
            'precio_unitario.required' => 'El dato costo unitario es requerido.',
            // 'detalle.required' => 'El dato detalle es requerido.'
        ];
    }
}
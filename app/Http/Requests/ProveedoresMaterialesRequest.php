<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProveedoresMaterialesRequest extends FormRequest
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
            'material_id' => 'required',
            'descripcion' => 'required',
            'unidad_medida_id'=> 'required',
            'precio_unitario'=> 'required',            
            'detalle' => 'nullable',
            'stock' => 'required|integer|min:0', // Asegúrate de que el stock sea un número entero no negativo
        ];
    }

    public function messages(): array
    {
        return [
            'proveedor_id.required' => 'El dato proveedor_id es requerido.',
            'material_id.required' => 'El dato material_id es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'unidad_medida_id.required' => 'El dato unidad de medida es requerido.',
            'precio_unitario.required' => 'El dato costo unitario es requerido.',
            'stock.required' => 'El dato stock es requerido.',
            'stock.integer' => 'El dato stock debe ser un número entero.',
            'stock.min' => 'El dato stock no puede ser negativo.',
        ];
    }
}
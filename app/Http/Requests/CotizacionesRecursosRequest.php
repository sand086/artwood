<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesRecursosRequest extends FormRequest
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
            'cotizacion_analisis_id' => 'required',
            'tipo_recurso_id' => 'required',
            'recurso_id' => 'required',
            'proveedor_id' => 'nullable',
            'unidad_medida_id' => 'required',
            'precio_unitario' => 'required',
            'porcentaje_ganancia'=> 'required',
            'precio_unitario_ganancia'=> 'nullable',
            'cantidad' => 'required',
            'tiempo_entrega' => 'required',
            'precio_total' => 'required',
            // 'usuario_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'cotizacion_analisis_id.required' => 'El dato analisis decotizacion es requerido.',
            'tipo_recurso_id.required' => 'El dato tipo de recurso es requerido.',
            'recurso_id.required' => 'El dato recurso es requerido.',
            'proveedor_id.required' => 'El dato proveedor es requerido.',
            'unidad_medida_id.required' => 'El dato unidad de medida es requerido.',
            'precio_unitario.required' => 'El dato precio unitario es requerido.',
            'porcentaje_ganancia.required' => 'El dato porcenjaje de ganancia es requerido.',
            'cantidad.required' => 'El dato cantidad es requerido.',
            'tiempo_entrega.required' => 'El dato tiempo de entrega es requerido.',
            'precio_total.required' => 'El dato precio total es requerido.',
        ];
    }
}
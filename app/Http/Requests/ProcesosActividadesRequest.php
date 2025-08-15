<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcesosActividadesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // O tu lógica de autorización
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required',
            'descripcion' => 'required',
            'proceso_id' => 'required',
            'area_id' => 'required',
            'unidad_medida_id' => 'required',
            'tiempo_estimado' => 'required',
            'costo_estimado' => 'required',
            'riesgos' => 'nullable|string|max:2048',
            'observaciones' => 'nullable|string|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'proceso_id.required' => 'El dato proceso es requerido.',
            'area_id.required' => 'El dato area es requerido.',
            'unidad_medida_id.required' => 'El dato unidad de medida es requerido.',
            'tiempo_estimado.required' => 'El dato tiempo estimado es requerido.',
            'costo_estimado.required' => 'El dato costo estimado es requerido.'
        ];
    }
}
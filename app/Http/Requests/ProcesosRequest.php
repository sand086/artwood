<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcesosRequest extends FormRequest
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
            'presupuesto_estimado' => 'required',
            'fecha_estimada' => 'nullable|date',
            'comentarios' => 'nullable|string|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'descripcion.required' => 'El dato descripcion es requerido.',
            'presupuesto_estimado.required' => 'El dato presupuesto_estimado es requerido.',
            // 'fecha_estimada.required' => 'El dato fecha_estimada es requerido.'
        ];
    }
}
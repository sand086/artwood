<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientesContactosRequest extends FormRequest
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
            'cliente_id' => 'required',
            'persona_id' => 'required',
            'cargo' => 'nullable',
            'telefono' => 'required',
            'correo_electronico' => 'required',
            // 'observaciones' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'cliente_id.required' => 'El dato cliente_id es requerido.',
            'persona_id.required' => 'El dato persona_id es requerido.',
            'telefono.required' => 'El dato telefono es requerido.',
            'correo_electronico.required' => 'El dato correo_electronico es requerido.',
            // 'observaciones.required' => 'El dato observaciones es requerido.'
        ];
    }
}
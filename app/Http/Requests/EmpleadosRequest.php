<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpleadosRequest extends FormRequest
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
            'persona_id' => 'required',
            'cargo' => 'required',
            'usuario_id' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'persona_id.required' => 'El dato persona_id es requerido.',
            'cargo.required' => 'El dato cargo es requerido.',
        ];
    }
}
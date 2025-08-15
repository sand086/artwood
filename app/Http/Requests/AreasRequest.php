<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AreasRequest extends FormRequest
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
            // Si no es sólo-estado, nombre es requerido
            'nombre'     => ['required_without:only_status', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
            // Siempre podemos permitir toggle de estado
            'estado'     => ['sometimes', 'in:A,I,E'],
            // Flag interno, no necesita validación estricta
            'only_status' => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.'
        ];
    }
}

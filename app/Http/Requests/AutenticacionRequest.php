<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AutenticacionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'usuario' => 'required|string|max:100',
            'contrasena' => 'required|string|min:6',
            'codigo_2fa' => 'nullable|digits:6'
        ];
    }

    /**
     * Mensajes de error personalizados.
     */
    public function messages(): array
    {
        return [
            'usuario.required' => 'El campo usuario es obligatorio.',
            'usuario.string' => 'El campo usuario debe ser una cadena de texto.',
            'usuario.max' => 'El usuario no puede tener más de 100 caracteres.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'codigo_2fa.required_if' => 'El código 2FA es obligatorio.',
            'codigo_2fa.digits' => 'El código 2FA debe tener 6 dígitos.'
        ];
    }
}

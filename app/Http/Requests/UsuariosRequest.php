<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsuariosRequest extends FormRequest
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
            'nombre'                => 'required|string|max:255',
            'role_id'               => 'required|integer',
            'nombres'               => 'required|string|max:255',
            'apellidos'             => 'required|string|max:255',
            'telefono'              => 'nullable|string|max:50',
            'email' => $this->isMethod('post')
                ? 'required|email'
                : 'required|email|unique:personas,email,' . $this->route('usuario')->persona_id . ',persona_id',



            'direccion'             => 'nullable|string|max:255',
            'password' => $this->isMethod('post')
                ? 'required|string|min:8|confirmed'
                : 'nullable|string|min:8|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'nombre.string'   => 'El dato nombre debe ser una cadena de texto.',
            'nombre.max'      => 'El dato nombre no debe exceder los 255 caracteres.',
            'role_id.required' => 'El dato role_id es requerido.',
            'role_id.integer'  => 'El dato role_id debe ser un número entero.',
            'nombres.required' => 'El dato nombres es requerido.',
            'nombres.string'   => 'El dato nombres debe ser una cadena de texto.',
            'nombres.max'      => 'El dato nombres no debe exceder los 255 caracteres.',
            'apellidos.required' => 'El dato apellidos es requerido.',
            'apellidos.string'   => 'El dato apellidos debe ser una cadena de texto.',
            'apellidos.max'      => 'El dato apellidos no debe exceder los 255 caracteres.',
            'telefono.string'   => 'El dato telefono debe ser una cadena de texto.',
            'telefono.max'      => 'El dato telefono no debe exceder los 50 caracteres.',
            'email.required'    => 'El dato email es requerido.',
            'email.email'       => 'El dato email debe ser una dirección de correo electrónico válida.',
            'email.max'         => 'El dato email no debe exceder los 255 caracteres.',
            'email.unique'      => 'El dato email ya está en uso.',
            'direccion.string'  => 'El dato direccion debe ser una cadena de texto.',
            'direccion.max'     => 'El dato direccion no debe exceder los 255 caracteres.',
            'password.required' => 'El dato password es requerido.',
            'password.string'   => 'El dato password debe ser una cadena de texto.',
            'password.min'      => 'El dato password debe tener al menos 8 caracteres.',
            'password.confirmed' => 'El dato password no coincide con la confirmación.',

        ];
    }
}

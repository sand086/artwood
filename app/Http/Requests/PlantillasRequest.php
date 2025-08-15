<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantillasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // O tu lógica de autorización
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required',
            'clave' => 'required',
            'modulo'=> 'nullable',
            'formato'=> 'required',
            'origen_datos'=> 'required',
            'fuente_datos'=> 'required',
            'tipo' => 'required',
            'html' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El dato nombre es requerido.',
            'clave.required' => 'El dato clave es requerido.',
            'formato.required' => 'El dato formato es requerido.',
            'origen_datos.required' => 'El dato origen de datos es requerido.',
            'fuente_datos.required' => 'El dato fuente de datos es requerido.',
            'tipo.required' => 'El dato tipo es requerido.',
            'html.required' => 'El dato html es requerido.'
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermisosRequest extends FormRequest
{
    public function rules()
    {
        if ($this->boolean('only_status')) {
            return [
                'estado' => 'required|in:A,I,E',
            ];
        }
        
        return [
            'name' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'guard_name' => 'required|string',
        ];
    }

    public function messages()
    {
        return [];
    }
}

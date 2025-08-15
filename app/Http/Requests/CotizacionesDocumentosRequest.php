<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CotizacionesDocumentosRequest extends FormRequest
{
    
    private string $allowedMimes;
    private int $maxSize;

    /**
     * Create a new request instance.
     *
     * @return void
     */
    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);
        
        $this->maxSize = (int) config('files.documents.max_size_kb', 5120); // Default to 20MB if not set
        $this->allowedMimes = implode(',', config('files.documents.allowed_mimes', ['pdf', 'doc', 'docx'])); // Provide a sensible default
    }

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
        // $maxSize = config('files.documents.max_size_kb');
        // $allowedMimes = implode(',', config('files.documents.allowed_mimes')); // Unimos el array en una cadena

        return [
            'cotizacion_solicitud_id' => 'required|integer|exists:cotizacionessolicitudes,cotizacion_solicitud_id', // Ensure this table/column is correct
            'documento' => 'required|file|mimes:' . $this->allowedMimes . '|max:' . $this->maxSize, // Max 20MB, adjust as needed
            'descripcion' => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'documento.required' => 'El documento es requerido.',
            'documento.file' => 'El documento debe ser un archivo.',
            'documento.mimes' => 'El documento debe tener un formato permitido.',
            'documento.max' => 'El documento no debe exceder los ' . $this->maxSize . ' Kb.',
        ];
    }
}
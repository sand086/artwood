<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth; // If you track user_id

use App\Models\CotizacionesDocumentos;
use App\Http\Requests\CotizacionesDocumentosRequest;
use App\Services\CotizacionesDocumentosService;

class CotizacionesDocumentosController extends Controller
{
    protected CotizacionesDocumentosService $cotizacionesDocumentoService;

    public function __construct(CotizacionesDocumentosService $cotizacionesDocumentoService)
    {
        $this->cotizacionesDocumentoService = $cotizacionesDocumentoService;
    }

    /**
     * Muestra la lista de cotizacionesDocumentos.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $columns = [
                ['data' => 'cotizacion_solicitud_id', 'field' => 'cotizacion_solicitud_id'],
                ['data' => 'nombre_documento_original', 'field' => 'nombre_documento_original'],
                ['data' => 'nombre_documento_sistema', 'field' => 'nombre_documento_sistema'],
                ['data' => 'descripcion', 'field' => 'descripcion'],
                ['data' => 'ruta_almacenamiento', 'field' => 'ruta_almacenamiento'],
                ['data' => 'tipo_mime', 'field' => 'tipo_mime'],
                ['data' => 'tamano_bytes', 'field' => 'tamano_bytes'],
                ['data' => 'estado', 'field' => 'estado'],
                ['data' => 'fecha_registro', 'field' => 'fecha_registro'],
                ['data' => 'fecha_actualizacion', 'field' => 'fecha_actualizacion'],
            ];

            $actionsConfig = [
                'edit' => false,
                'delete' => true,
                'custom' => [
                    0 => [
                        'label' => '',
                        'route' => 'cotizacionesdocumentos.stream',
                        'method' => 'GET',
                        'routeParams' => ['cotizacionesdocumento' => 'cotizacion_documento_id'],
                        'icon' => '/images/icons/crud/iconos_ojo_abierto.svg',
                        'iconType'=> 'img',
                        'iconSize'=> 'w-9',
                        'iconWidth'=> '30',
                        'class' => 'btn btn-primary btn-sm inline-flex items-center justify-center bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800 p-1 rounded',
                        'title' => 'Ver documento',
                        'target' => '_blank'
                    ],
                ],
            ];

            $filters = [];
            // Asume que el ID del proveedor se envía como parámetro en la solicitud AJAX
            // (ej. /proveedorescontactos?proveedor_id=123)
            if ($request->has('cotizacion_solicitud_id') && !empty($request->input('cotizacion_solicitud_id'))) {
                $filters['cotizacion_solicitud_id'] = $request->input('cotizacion_solicitud_id');
            } // else {
                // Opcional: Si no se proporciona proveedor_id, podrías devolver un error
                // o una tabla vacía para evitar mostrar todos los contactos.
                // return response()->json(['data' => []]); // Ejemplo: devolver vacío
                // Log::warning('Solicitud de DataTable para ProveedoresContactos sin proveedor_id.');
                // O simplemente permitir que muestre todo si esa es la lógica deseada (menos común para sub-tablas)
            // }

            return $this->cotizacionesDocumentoService->getDataTable($columns, $actionsConfig, 'cotizacionesdocumentos', 'cotizacion_documento_id', $filters);
        }

        return view('modules.CotizacionesDocumentos.index', ['canAdd' => true]);
    }

    /**
     * Almacena un nuevo cotizacionesDocumento.
     */
    public function store(CotizacionesDocumentosRequest $request)
    {
        $validated = $request->validated();

        $cotizacionSolicitudId = $validated['cotizacion_solicitud_id'];
        $file = $validated['documento'];
        $descripcion = $validated['descripcion'];

        $originalName = $file->getClientOriginalName();
        $mimeType = $file->getClientMimeType();
        $size = $file->getSize();
        
        // Define a path, e.g., cotizaciones_documentos/{cotizacion_solicitud_id}/unique_filename.ext
        $filename = uniqid() . '_' . $originalName;
        $path = $file->storeAs("public/cotizaciones_documentos/{$cotizacionSolicitudId}", $filename);
        // Note: `storeAs` returns the full path including 'public/'. 
        // If you want a path relative to `storage/app/public`, adjust accordingly or use `Storage::url($path)` for access.

        $documento = CotizacionesDocumentos::create([
            'cotizacion_solicitud_id' => $cotizacionSolicitudId,
            'nombre_documento_original' => $originalName,
            'nombre_documento_sistema' => $filename, // Store the generated unique filename
            'descripcion' => $descripcion,
            'ruta_almacenamiento' => $path, // Store the path as returned by storeAs
            'tipo_mime' => $mimeType,
            'tamano_bytes' => $size,
            'fecha_registro' => now(),
            'estado' => 'A', // Default state
        ]);

        if ($documento) {
            // BaseModule typically expects 'record' or 'data'
            return response()->json(['success' => true, 'message' => 'Documento subido exitosamente.', 'record' => $documento]);
        } else {
            Storage::delete($path); // Clean up stored file if DB entry failed
            return response()->json(['success' => false, 'message' => 'Error al guardar la información del documento.'], 500);
        }
    }

    /**
     * Muestra el cotizacionesDocumento solicitado.
     */
    public function edit(CotizacionesDocumentos $cotizacionesdocumento)
    {
        return response()->json($cotizacionesdocumento);
    }

    /**
     * Actualiza el cotizacionesDocumento especificado.
     */
    public function update(CotizacionesDocumentosRequest $request, CotizacionesDocumentos $cotizacionesdocumento)
    {
        $validated = $request->validated();

        try {
            $this->cotizacionesDocumentoService->update($cotizacionesdocumento, $validated);
            return response()->json([
                'success' => true,
                'message' => 'CotizacionesDocumentos actualizado correctamente.',
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error al actualizar cotizacionesDocumento', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cotizacionesDocumento.',
            ], 500);
        }
    }

    /**
     * Elimina el cotizacionesDocumento especificado.
     */
    public function destroy(CotizacionesDocumentos $cotizacionesdocumento)
    {
        try {
            Storage::delete($cotizacionesdocumento->ruta_almacenamiento); // Delete the physical file
            $this->cotizacionesDocumentoService->delete($cotizacionesdocumento);
            return response()->json([
                'success' => true,
                'message' => 'CotizacionesDocumentos eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            Log::error('Error al eliminar cotizacionesDocumento', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar el cotizacionesDocumento.',
            ], 500);
        }
    }

    /**
     * Permite visualizar o descargar un documento.
     * Utiliza Route Model Binding para obtener la instancia de CotizacionesDocumentos.
     */
    public function streamDocument(CotizacionesDocumentos $cotizacionesdocumento)
    {
        // Opcional: Verificar permisos de acceso al documento
        // Ejemplo: if (Auth::user()->cannot('view', $cotizacionesdocumento)) {
        //     abort(403, 'No tienes permiso para ver este documento.');
        // }

        $path = $cotizacionesdocumento->ruta_almacenamiento; // Ejemplo: "public/cotizaciones_documentos/123/unique_name.pdf"

        // Los archivos se guardan con storeAs("public/...", ...) que usa el disco por defecto (usualmente 'local').
        // La ruta almacenada es relativa a la raíz de ese disco (storage/app/).
        // Por lo tanto, usamos Storage::disk('local') o simplemente Storage:: si 'local' es el default.
        $disk = Storage::disk('local'); // O el disco que uses por defecto si es diferente

        if ($disk->exists($path)) {
            $fileContents = $disk->get($path);
            $mimeType = $cotizacionesdocumento->tipo_mime ?: $disk->mimeType($path);

            // Para tipos de archivo que los navegadores suelen mostrar inline (PDFs, imágenes, texto)
            $inlineMimeTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif', 'text/plain'];
            if (in_array($mimeType, $inlineMimeTypes)) {
                return Response::make($fileContents, 200, [
                    'Content-Type' => $mimeType,
                    'Content-Disposition' => 'inline; filename="' . $cotizacionesdocumento->nombre_documento_original . '"'
                ]);
            }

            // Para otros tipos de archivo, forzar la descarga
            return $disk->download(
                $path,
                $cotizacionesdocumento->nombre_documento_original
            );
        }
        
        Log::warning("Archivo no encontrado en streamDocument: ID {$cotizacionesdocumento->cotizacion_documento_id}, Ruta: {$path}");
        abort(404, 'Archivo no encontrado.');
    }

    /**
     * Permite la descarga directa de un documento.
     * Este método es un ejemplo y podría no ser usado directamente por el botón "Ver Documento"
     * si streamDocument ya maneja la descarga para ciertos tipos MIME.
     */
    public function download($id)
    {
        $documento = CotizacionesDocumentos::findOrFail($id); // Corregido el nombre del Modelo

        // Add authorization checks if necessary

        // Asumiendo que ruta_almacenamiento es la columna correcta y el disco es 'local' (o el default)
        if (Storage::disk('local')->exists($documento->ruta_almacenamiento)) {
            return Storage::disk('local')->download($documento->ruta_almacenamiento, $documento->nombre_documento_original);
        }
        abort(404, 'Archivo no encontrado.');
    }

}
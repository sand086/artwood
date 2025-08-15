<?php

namespace App\Services\Plantillas;

use App\Models\Plantillas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\Response;

class DocumentoGeneradorService
{
    /**
     * Genera un documento a partir de una plantilla y contexto.
     *
     * @param int $idPlantilla
     * @param array $contexto
     * @return Response
     * @throws \Exception
     */
    public function generarDocumento(int $idPlantilla, array $contexto = []): Response
    {
        $plantilla = Plantillas::findOrFail($idPlantilla);

        $datos = $this->obtenerDatos($plantilla, $contexto);
        
        $html = Blade::render($plantilla->html, $datos);

        return match ($plantilla->formato) {
            'PDF' => $this->generarPdf($html, $datos, $plantilla->clave),
            'EXCEL' => $this->generarExcel($datos), // placeholder para futuro
            'WORD' => $this->generarWord($html),    // placeholder para futuro
            default => throw new \Exception('Formato no soportado: ' . $plantilla->formato),
        };
    }

    private function obtenerDatos(Plantillas $plantilla, array $contexto): array
    {
        return match ($plantilla->origen_datos) {
            'TABLA' => $this->desdeTabla($plantilla->fuente_datos, $contexto),
            'CONSULTA' => $this->desdeConsulta($plantilla->fuente_datos, $contexto),
            'FUNCION' => $this->desdeFuncion($plantilla->fuente_datos, $contexto),
            default => throw new \Exception('Origen de datos no soportado: ' . $plantilla->origen_datos),
        };
    }

    private function desdeTabla(string $tabla, array $contexto): array
    {
        if (!isset($contexto['id'])) {
            throw new \Exception("Falta el parámetro 'id' en el contexto para tabla.");
        }

        $registro = DB::table($tabla)->where('id', $contexto['id'])->first();

        return ['registro' => (array)$registro];
    }

    private function desdeConsulta(string $base64Sql, array $contexto): array
    {
        $sql = base64_decode($base64Sql);

        foreach ($contexto as $clave => $valor) {
            $sql = str_replace("{{{$clave}}}", addslashes($valor), $sql);
        }

        $resultado = DB::select(DB::raw($sql));

        return ['resultados' => json_decode(json_encode($resultado), true)];
    }

    private function desdeFuncion(string $fuente, array $contexto): array
    {
        [$modulo, $metodo] = explode('.', $fuente);

        $serviceMap = [
            'cotizacionesanalisis' => \App\Services\CotizacionesAnalisisService::class,
            // otros módulos aquí
        ];

        if (!isset($serviceMap[$modulo])) {
            throw new \Exception("Módulo [$modulo] no registrado.");
        }

        $service = app($serviceMap[$modulo]);

        if (!method_exists($service, $metodo)) {
            throw new \Exception("Método [$metodo] no encontrado en el módulo [$modulo].");
        }

        return $service->$metodo($contexto['id']);
    }

    private function generarExcel(array $datos)
    {
        // Placeholder: aquí puedes implementar lógica con Laravel Excel
        throw new \Exception('Generación de Excel aún no implementada.');
    }

    private function generarWord(string $html)
    {
        // Placeholder: podrías usar PHPWord o similar
        throw new \Exception('Generación de Word aún no implementada.');
    }

    public function renderVista(int $idPlantilla, array $contexto): View
    {
        $plantilla = Plantillas::where('plantilla_id', $idPlantilla)->firstOrFail();

        $metodo = $plantilla->metodo_obtener_datos ?? 'obtenerDatosDocumento';
        $servicio = app($plantilla->clase_servicio); // ejemplo: App\Services\CotizacionesAnalisisService

        if (!method_exists($servicio, $metodo)) {
            throw new \Exception("Método {$metodo} no existe en {$plantilla->clase_servicio}");
        }

        $datos = $servicio->$metodo($contexto['id']);

        // Vista genérica de previsualización
        return view('modules.Plantillas.vista_previa', [
            'contenido_html' => $plantilla->html,
            'datos' => $datos
        ]);
    }

    /**
     * Genera un PDF con DomPDF, manejando encabezados, pies de página y opciones.
     *
     * @param string $html
     * @param array $datos
     * @return Response
     */
    private function generarPdf(string $html, array $datos, string $clavePlantilla): Response
    {
        // Opciones por defecto
        $formato = $datos['config']['formato'] ?? 'Letter';
        $orientacion = $datos['config']['orientacion'] ?? 'portrait';
        $conEncabezado = $datos['config']['encabezado'] ?? true;
        $conPieDePagina = $datos['config']['piedepagina'] ?? true;
        
        $pdf = Pdf::loadHTML($html)->setPaper($formato, $orientacion);
        
        $dompdf = $pdf->getDomPDF();
        $canvas = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();

        if ($conEncabezado) {
            $canvas->page_script(function($pageNumber, $total_pages) use ($canvas, $fontMetrics, $datos) {
                $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
                $version = 'V ' . ($datos['version'] ?? '1.0');
                $canvas->text(50, 30, $version, $font, 9, [0.66, 0.66, 0.66]);
            });
        }
        
        if ($conPieDePagina) {
            $canvas->page_script(function($pageNumber, $total_pages) use ($canvas, $fontMetrics, $datos) {
                $font = $fontMetrics->getFont('DejaVu Sans', 'normal');
                
                // Información de la empresa
                $empresaNombre = $datos['empresa']['nombre'] ?? 'Empresa';
                $empresaInfo = sprintf(
                    '%s | Dirección: %s | Teléfono: %s | Email: %s',
                    $empresaNombre,
                    $datos['empresa']['direccion'] ?? '',
                    $datos['empresa']['telefono'] ?? '',
                    $datos['empresa']['email'] ?? ''
                );
                
                // Numeración de página
                $pageNumberText = "Página $pageNumber de $total_pages";
                
                // Posición de la información de la empresa
                $canvas->text(
                    50, // Posición X desde el borde izquierdo
                    $canvas->get_height() - 30, // Posición Y desde el borde inferior
                    $empresaInfo,
                    $font,
                    8
                );
                
                // Posición de la numeración de página (alineado a la derecha)
                $pageNumberWidth = $fontMetrics->getTextWidth($pageNumberText, $font, 8);
                $canvas->text(
                    $canvas->get_width() - 50 - $pageNumberWidth, // Posición X desde el borde derecho
                    $canvas->get_height() - 30, // Posición Y desde el borde inferior
                    $pageNumberText,
                    $font,
                    8
                );
            });
        }

        return $pdf->stream($clavePlantilla . '.pdf');
    }

}

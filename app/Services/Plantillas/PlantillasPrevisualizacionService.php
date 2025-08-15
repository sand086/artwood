<?php

namespace App\Services\Plantillas;

use Illuminate\Support\Facades\Blade;

class PlantillasPrevisualizacionService
{
    public function render(string $contenidoHtml): string
    {
        // Reemplaza variables {{ $algo }} por texto visible
        $renderizado = preg_replace_callback('/{{\s*(.*?)\s*}}/', function ($matches) {
            return '{{ ' . $matches[1] . ' }}';
        }, $contenidoHtml);

        // Opcional: podrías eliminar instrucciones como @if, @foreach
        $renderizado = preg_replace('/@(\w+)(\s*\(.*?\))?/', '', $renderizado);

        return $renderizado;
    }


    public function renderEjecutado(string $contenidoHtml): string
    {
        $datos = $this->generarVariablesDummy($contenidoHtml);

        // Genera una vista temporal (blade-inline)
        $viewName = '__plantilla_previa_' . uniqid();

        // Guarda el contenido Blade en una vista temporal (en el disco si se requiere)
        file_put_contents(resource_path("views/temp/{$viewName}.blade.php"), $contenidoHtml);

        try {
            return view("temp.{$viewName}", $datos)->render();
        } catch (\Throwable $e) {
            return "<pre>Error al renderizar plantilla:\n" . $e->getMessage() . "</pre>";
        }
    }

    private function generarVariablesDummy(string $html): array
    {
        $datos = [];

        // Detectar $variables y $var['clave']
        preg_match_all('/\$\w+(?:\[[^\]]+\])*/', $html, $matches);

        foreach (array_unique($matches[0]) as $var) {
            $path = preg_replace('/\[(\'|")?([^\'"\]]+)(\'|")?\]/', '.$2', $var); // $cliente['nombre'] => $cliente.nombre
            $segments = explode('.', ltrim($path, '$'));

            $current = &$datos;
            foreach ($segments as $key) {
                if (!is_array($current)) {
                    $current = [];
                }

                if (!isset($current[$key]) || (!is_array($current[$key]) && $key !== end($segments))) {
                    if ($key === end($segments)) {
                        $current[$key] = 'Valor demo';
                    } else {
                        $current[$key] = [];
                    }
                }

                $current = &$current[$key];
            }
        }

        // Detectar @foreach($categorias as $categoria)
        preg_match_all('/@foreach\s*\(\s*\$(\w+)\s+as/', $html, $loops);
        foreach ($loops[1] as $arrayVar) {
            if (!isset($datos[$arrayVar]) || !is_array($datos[$arrayVar])) {
                $datos[$arrayVar] = [
                    ['clave' => 'X001', 'nombre' => 'Concepto 1', 'unidad' => 'm2', 'cantidad' => 1, 'precio_unitario' => 100, 'subtotal' => 100],
                    ['clave' => 'X002', 'nombre' => 'Concepto 2', 'unidad' => 'hr', 'cantidad' => 2, 'precio_unitario' => 150, 'subtotal' => 300]
                ];
            }
        }

        return $datos;
    }
}

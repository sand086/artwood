<?php

namespace App\Observers;

use App\Models\CotizacionesRecursos;
use App\Models\CotizacionesAnalisis; // Asegúrate de que este modelo esté importado

class CotizacionesRecursosObserver
{
    /**
     * Se ejecuta después de que un recurso es creado.
     */
    public function created(CotizacionesRecursos $cotizacionRecurso): void
    {
        // Llama al método unificado para actualizar ambos totales
        $this->updateAnalisisTotals($cotizacionRecurso->cotizacion_analisis_id);
    }

    /**
     * Se ejecuta después de que un recurso es actualizado.
     */
    public function updated(CotizacionesRecursos $cotizacionRecurso): void
    {
        // Llama al método unificado para actualizar ambos totales
        $this->updateAnalisisTotals($cotizacionRecurso->cotizacion_analisis_id);
    }

    /**
     * Se ejecuta después de que un recurso es eliminado.
     */
    public function deleted(CotizacionesRecursos $cotizacionRecurso): void
    {
        // Llama al método unificado para actualizar ambos totales
        // Es crucial que cotizacion_analisis_id esté disponible aquí antes de que el recurso se elimine por completo
        $this->updateAnalisisTotals($cotizacionRecurso->cotizacion_analisis_id);
    }

    /**
     * Lógica para calcular y actualizar el tiempo total y el costo total en el análisis de cotización.
     *
     * @param int $cotizacionAnalisisId El ID del análisis de cotización padre.
     */
    protected function updateAnalisisTotals(int $cotizacionAnalisisId): void
    {
        $analisis = CotizacionesAnalisis::find($cotizacionAnalisisId);

        if ($analisis) {
            // Calcular tiempo_total (máximo tiempo_entrega de los recursos asociados)
            $tiempoMaximo = CotizacionesRecursos::where('cotizacion_analisis_id', $cotizacionAnalisisId)->max('tiempo_entrega');
            $analisis->tiempo_total = $tiempoMaximo ?? 0; // Asigna 0 si no hay recursos o tiempo_entrega es nulo

            // Calcular costo_subtotal (suma de precio_total de los recursos asociados)
            $costoSubtotal = CotizacionesRecursos::where('cotizacion_analisis_id', $cotizacionAnalisisId)->sum('precio_total');
            $analisis->costo_subtotal = $costoSubtotal ?? 0.00; // Asigna 0.00 si no hay recursos o precio_total es nulo

            $costoTotal = $costoSubtotal + ($costoSubtotal * ($analisis->impuesto_iva / 100));
            $analisis->costo_total = $costoTotal ?? 0.00; // Asigna 0.00 si no hay recursos o precio_total es nulo

            // Guarda los cambios en el modelo CotizacionesAnalisis
            $analisis->save();
        }
    }
}

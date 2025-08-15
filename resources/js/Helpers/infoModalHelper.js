import axios from "axios";
import { handleAjaxError } from "./utils";

/**
 * Muestra un modal con información detallada obtenida desde una URL.
 * @param {string} url - La URL para obtener el contenido HTML del modal.
 * @param {string} title - El título para el encabezado del modal.
 */
export function showInfoModal(url, title) {
    const modalId = 'infoDetailModal';
    const modalTitleEl = document.getElementById(`${modalId}Title`);
    const modalBodyEl = document.getElementById(`${modalId}Body`);
    const modal = document.getElementById(modalId);

    if (!modal || !modalTitleEl || !modalBodyEl) {
        console.error('El modal de información o sus elementos no se encontraron en el DOM.');
        return;
    }

    // 1. Mostrar modal con estado de "cargando"
    modalTitleEl.textContent = title;
    modalBodyEl.innerHTML = '<div class="text-center p-8">Cargando...</div>';
    window.Helpers.showModal(modalId);

    // 2. Hacer la petición AJAX para obtener el contenido
    axios.get(url)
        .then(response => {
            // 3. Poblar el cuerpo del modal con la respuesta (que se espera sea HTML)
            modalBodyEl.innerHTML = response.data;
            // Re-inicializar iconos si la nueva vista los tiene
            if (window.lucide) {
                window.lucide.createIcons();
            }
        })
        .catch(error => {
            // 4. Manejar errores
            console.error('Error al cargar contenido para el modal:', error);
            modalBodyEl.innerHTML = `
                <div class="text-center text-red-500 p-8">
                    <p>No se pudo cargar la información.</p>
                    <p class="text-sm text-gray-500 mt-2">${error.response?.data?.message || error.message}</p>
                </div>`;
            // Opcional: usar el manejador de errores global si no es un error de "no encontrado"
            if (error.response?.status !== 404) handleAjaxError(error);
        });
}

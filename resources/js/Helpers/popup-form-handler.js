/**
 * popup-form-handler.js
 *
 * Gestiona la apertura de ventanas emergentes para crear nuevos registros
 * y la actualización del campo <select> correspondiente en la ventana principal
 * al recibir una respuesta.
 */

let activePopup = null; // Referencia a la ventana emergente activa
let popupCheckInterval = null; // ID del intervalo para monitorear el popup

/**
 * Abre una ventana emergente para la creación de un recurso.
 * @param {string} url - La URL del formulario de creación.
 * @param {string} targetSelectId - El ID del elemento <select> que se debe actualizar.
 */
function openCreationPopup(url, targetSelectId) {
    // Añadimos el targetSelectId a la URL para que el popup sepa a quién responder.
    // Si ya hay un popup abierto, simplemente lo enfocamos.
    if (activePopup && !activePopup.window.closed) {
        activePopup.window.focus();
        return;
    }

    const urlWithTarget = new URL(url, window.location.origin);
    urlWithTarget.searchParams.append('targetSelectId', targetSelectId);
    urlWithTarget.searchParams.append('openModal', 'true');
    urlWithTarget.searchParams.append('windowClose', 'true');

    // Dimensiones y posición para la ventana emergente
    const width = 800;
    const height = 600;
    const left = (screen.width / 2) - (width / 2);
    const top = (screen.height / 2) - (height / 2);

    const popup = window.open(
        urlWithTarget.toString(),
        'creationPopup',
        `width=${width},height=${height},top=${top},left=${left},scrollbars=yes,resizable=yes`
    );

    // Guardamos la referencia al popup y su select de destino
    activePopup = { window: popup, targetSelectId: targetSelectId };

    // Monitoreamos si el popup se cierra
    popupCheckInterval = setInterval(() => {
        if (activePopup && activePopup.window.closed) {
            console.warn(`[PopupHandler] El popup para #${activePopup.targetSelectId} fue cerrado sin guardar.`);
            
            // Disparamos un evento para notificar a la ventana principal
            window.dispatchEvent(new CustomEvent('popup-closed-without-save', {
                detail: { targetSelectId: activePopup.targetSelectId },
                bubbles: true
            }));

            // Limpiamos el estado y el intervalo
            clearInterval(popupCheckInterval);
            activePopup = null;
        }
    }, 500); // Comprobar cada 500ms
}

/**
 * Actualiza un campo <select> con una nueva opción y la selecciona.
 * @param {string} selectId - El ID del <select> a actualizar.
 * @param {object} record - El registro con los datos (debe tener id y texto).
 * @param {string} valueField - El nombre del campo para el valor de la opción.
 * @param {string} labelField - El nombre del campo para el texto de la opción.
 */
function updateSelectWithNewRecord(selectId, record, valueField, labelField) {
    const selectElement = document.getElementById(selectId);
    if (!selectElement) {
        console.warn(`[PopupHandler] No se encontró el select con ID: ${selectId}`);
        return;
    }

    // Disparamos un evento para que el componente x-form-select recargue sus opciones.
    // El componente escuchará este evento y luego disparará 'options-loaded'.
    selectElement.dispatchEvent(new Event('reload-options'));

    // Escuchamos una sola vez el evento 'options-loaded' para asegurarnos de que
    // las nuevas opciones (incluida la que acabamos de crear) están en el DOM.
    selectElement.addEventListener('options-loaded', () => {
        // Ahora que las opciones están recargadas, disparamos el evento para seleccionar el nuevo valor.
        selectElement.dispatchEvent(new CustomEvent('set-value', {
            detail: { value: record[valueField] },
            bubbles: true
        }));
        selectElement.focus();
    }, { once: true });
}

export function initPopupFormHandler() {
    // Listener centralizado para los mensajes de los popups
    window.addEventListener('message', (event) => {
        if (event.origin !== window.location.origin || !event.data.action || event.data.action !== 'record-created-in-popup') {
            return;
        }

        const { targetSelectId, registro, valueField, labelField } = event.data;
        console.log(`[PopupHandler] Registro recibido para el select #${targetSelectId}:`, registro);

        // Si recibimos un mensaje de éxito, significa que el popup se cerrará solo.
        // Limpiamos nuestro monitor para que no dispare el evento 'popup-closed-without-save'.
        if (popupCheckInterval) {
            clearInterval(popupCheckInterval);
            activePopup = null;
        }
        updateSelectWithNewRecord(targetSelectId, registro, valueField, labelField);
    });

    // Listener para los botones que abren los popups
    document.body.addEventListener('click', function(e) {
        const trigger = e.target.closest('.btn-open-popup-creator');
        if (trigger) {
            e.preventDefault();
            const url = trigger.getAttribute('href');
            const targetSelectId = trigger.dataset.targetSelectId;
            if (url && targetSelectId) {
                openCreationPopup(url, targetSelectId);
            } else {
                console.error('[PopupHandler] El botón debe tener un href y un atributo data-target-select-id.');
            }
        }
    });

    console.log('[PopupHandler] Inicializado.');
}
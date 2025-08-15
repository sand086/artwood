import '../CotizacionesResponsables/index.js';
import '../CotizacionesDocumentos/index.js';
import '../CotizacionesAnalisis/index.js';

import { abrirVentana } from '../../Helpers/utils.js';  // Asegúrate de la ruta
window.abrirVentana = abrirVentana;

const config = {
    moduleName: 'CotizacionesSolicitudes',
    baseUrl: '/cotizacionessolicitudes/',
    idField: 'cotizacion_solicitud_id',
    formFields: ['tipo_solicitud_id', 'cliente_id', 'fuente_id', 'nombre_proyecto', 'descripcion', 
                'fecha_estimada','control_version', 'usuario_id', 'estado_id'],
    moduleForm: 'cotizacionessolicitudesForm',
    moduleTable: 'cotizacionessolicitudesTable',
    moduleModal: 'cotizacionessolicitudesModal',
    closeModalOnSave: true,
    resetFormOnSave: false,
    targetTab: 'solicitud',
    columns: [
        { data: 'consecutivo', name: 'consecutivo', title: 'Consecutivo' },
        { data: 'tipo_solicitud_nombre', name: 'tipo_solicitud_nombre', title: 'Tipo Solicitud' },
        { data: 'cliente_nombre', name: 'cliente_nombre', title: 'Cliente' },
        { data: 'nombre_proyecto', name: 'nombre_proyecto', title: 'Nombre Proyecto' },
        { data: 'descripcion', name: 'descripcion', title: 'Descripci&oacute;on' },
        { data: 'fecha_estimada', name: 'fecha_estimada', title: 'Fecha Estimada' },
        { data: 'control_version', name: 'control_version', title: 'Control Versi&oacute;on' },
        { data: 'usuario_nombre', name: 'usuario_nombre', title: 'Usuario' },
        { data: 'estado_nombre', name: 'estado_nombre', title: 'Estado' },
        // { data: 'fecha_registro', name: 'fecha_creacion', title: 'Fecha Creacion' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const cotizacionessolicitudesModule = new BaseModule(config);
cotizacionessolicitudesModule.init();

// Asegurar que el namespace Artwood y el módulo existen
window.Artwood = window.Artwood || {};
window.Artwood.CotizacionesSolicitudes = window.Artwood.CotizacionesSolicitudes || {};

/**
 * Guarda un nuevo cliente y contacto rápidamente.
 * @param {object} formData Los datos del formulario del modal.
 * @param {string} storeUrl La URL del endpoint para guardar.
 */
window.Artwood.CotizacionesSolicitudes.saveQuickClient = function(formData, storeUrl) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(storeUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json',
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Evento para que el modal se cierre y reinicie
            window.dispatchEvent(new CustomEvent('quick-client-success', { detail: data.client }));
            // Evento para que el formulario principal (solicitud.blade.php) actualice su select
            window.dispatchEvent(new CustomEvent('client-created', { detail: data.client }));
        } else if (data.errors) {
            // Evento para que el modal muestre los errores de validación
            window.dispatchEvent(new CustomEvent('quick-client-errors', { detail: data.errors }));
        } else {
            // Evento para que el modal muestre un error genérico
            window.dispatchEvent(new CustomEvent('quick-client-generic-error', { detail: data.message || 'Ocurrió un error al procesar la solicitud.' }));
        }
    })
    .catch(error => {
        console.error('Error en saveQuickClient:', error);
        window.dispatchEvent(new CustomEvent('quick-client-generic-error', { detail: 'Error de conexión al intentar guardar el cliente/prospecto.' }));
    });
};

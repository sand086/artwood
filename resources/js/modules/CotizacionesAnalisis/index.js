import '../CotizacionesRecursos/index.js';
import { populateFormFromUrlParams, 
        formatearMoneda, 
        desformatearMoneda, 
        renderMoneda, 
        ejecutarAccionDesdeURL } from '../../Helpers/utils.js'; 
window.MonedaHelpers = { formatearMoneda, desformatearMoneda };

const urlParams = new URLSearchParams(window.location.search);
const openModal = urlParams.get('openModal') === 'true';
const windowClose = urlParams.get('windowClose') === 'true';
const mode = urlParams.get('modo') || 'nuevo'; // Por defecto, 'nuevo' si no se especifica
const id = urlParams.get('id') || null; // ID del registro a editar, si existe

const config = {
    moduleName: 'CotizacionesAnalisis',
    baseUrl: '/cotizacionesanalisis/',
    idField: 'cotizacion_analisis_id',
    formFields: ['cotizacion_solicitud_id', 'tipo_proyecto_id', 'descripcion_solicitud', 'tiempo_total',
                'costo_subtotal', 'impuesto_iva', 'costo_total', 'control_version'],
    moduleForm: 'cotizacionesanalisisForm',
    moduleTable: 'cotizacionesanalisisTable',
    moduleModal: 'cotizacionesanalisisModal',
    closeModalOnSave: true,
    resetFormOnSave: false,
    targetTab: 'analisis',
    showFormEventName: 'show-form-analisis',
    columns: [
        { data: 'consecutivo', name: 'consecutivo', title: 'Solicitud' },
        { data: 'tipo_proyecto_nombre', name: 'tipo_proyecto_nombre', title: 'Tipo Proyecto' },
        { data: 'tiempo_total', name: 'tiempo_total', title: 'Tiempo Total' },
        { data: 'costo_subtotal', name: 'costo_subtotal', title: 'Costo SubTotal', render: renderMoneda },
        // { data: 'impuesto_iva', name: 'impuesto_iva', title: 'Impuesto IVA' },
        { data: 'costo_total', name: 'costo_total', title: 'Costo Total', render: renderMoneda },
        { data: 'control_version', name: 'control_version', title: 'Versi&oacute;n' },
        { data: 'usuario_nombre', name: 'usuario_nombre', title: 'Usuario' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false } 
    ],
    openModalOnLoad: openModal, // Parámetro determina si abrir el modal al cargar la página
    windowCloseSave: windowClose, // Parámetro determina si cerrar la ventana al guardar
    onEditSuccess: (data) => {
        window.dispatchEvent(new CustomEvent('show-form-analisis', {
            detail: {
                costo_subtotal: data.costo_subtotal, // Asegúrate de que 'data' contenga estas propiedades
                impuesto_iva: data.impuesto_iva,
            }
        }));
    },
    afterLoadData: function(data, formSelector) {
        window.dispatchEvent(new CustomEvent('datos-cargados-analisis', {
            detail: { data: data, form: formSelector }
        }));

        if (data.cotizacion) {
            // Asume que tu formulario tiene los mismos 'name' que las propiedades del objeto cotizacion
            for (const field of ['cliente_contacto_id', 'empleado_responsable_id', 'plantilla_id', 'condiciones_comerciales', 'datos_adicionales']) {
                const element = document.querySelector(`[name="${field}"]`);
                if (element) {
                    const value = data.cotizacion[field] || '';
                    if (element.tagName === 'SELECT') {
                        // Si es un SELECT, encontramos la opción que coincida con el valor y la seleccionamos
                        const selectOption = () => {
                            const option = element.querySelector(`option[value="${value}"]`);
                            if (option) {
                                option.selected = true;
                                element.dispatchEvent(new Event('change', { bubbles: true })); // Disparamos un evento de cambio
                                return true; // Indicamos que se ha completado
                            }
                            return false;
                        };
                        
                        // Si la opción ya está disponible, la seleccionamos
                        if (!selectOption()) {
                            // Si no, iniciamos un MutationObserver
                            const observer = new MutationObserver((mutations, obs) => {
                                // Cuando cambie el DOM, intentamos seleccionar la opción de nuevo
                                if (selectOption()) {
                                    obs.disconnect(); // Desconectamos el observador una vez que la opción se encuentra
                                }
                            });
                            // Configuramos el observador para que vigile los hijos del select
                            observer.observe(element, { childList: true, subtree: true });
                        }
                    } else {
                        // Para INPUTS y TEXTAREAS, simplemente asignamos el valor
                        element.value = value;
                    }
                }
            }
        }
    }
};

const cotizacionesanalisisModule = new BaseModule(config);
cotizacionesanalisisModule.init();

window.Artwood = window.Artwood || {};
window.Artwood.Modules = window.Artwood.Modules || {}; // Crear Modules si no existe

// Exponer la instancia del módulo para que otras partes de la aplicación puedan accederla
window.Artwood.Modules.CotizacionesAnalisis = cotizacionesanalisisModule;

// Si el modal está configurado para abrirse al cargar (openModalOnLoad es true),
// y queremos poblar el formulario con parámetros de la URL.
// Esto asume que al abrirse así, es para un nuevo registro y el formulario está en su estado inicial.
if (config.openModalOnLoad) {
    // console.info('Poblando formulario de análisis desde parámetros URL al cargar la página...');
    const formId = cotizacionesanalisisModule.config.moduleForm;
    const formFields = cotizacionesanalisisModule.config.formFields;
 
    // Llamar a la función auxiliar para poblar el formulario.
    populateFormFromUrlParams(formId, formFields, false); // true para debugging
}

window.Artwood.CotizacionesAnalisis = window.Artwood.CotizacionesAnalisis || {};

$(document).on('xhr.dt', `#${config.moduleTable}`, function (e, settings, json, xhr) {
    if (json && json.impuestoIvaDefault !== undefined && json.impuestoIvaDefault !== null) {
        const impuestoIvaDefault = json.impuestoIvaDefault;
        
        // Disparar un evento global para que Alpine.js en analisis.blade.php lo escuche
        window.dispatchEvent(new CustomEvent('analisis-impuesto-iva-default-actualizado', {
            detail: {
                defaultIva: impuestoIvaDefault
            }
        }));
        // console.log(`Evento 'analisis-impuesto-iva-default-actualizado' disparado con: ${impuestoIvaDefault}`);
    } else {
        console.warn('impuestoIvaDefault no encontrado en la respuesta AJAX del DataTable de Analisis.');
    }
});

window.addEventListener('cotizacion-guardada', (event) => {
    // Asegúrate de que `cotizacionesanalisisModule` esté accesible aquí
    if (cotizacionesanalisisModule && cotizacionesanalisisModule.table) {
        cotizacionesanalisisModule.table.ajax.reload(null, false); // false para mantener la paginación
    }
});

/**
 * Ejecuta una acción específica (como editar) desde la URL del DataTable.
 * @param {object} config Configuración del módulo.
 * @param {function} callbackAccion Función que define la acción a ejecutar.
 */
$(`#${config.moduleTable}`).on('draw.dt', function() {
    const callbackAccion = (mode, id) => {
        if (mode === 'editar') {
            const editButton = document.querySelector(`button[data-id="${id}"].editar`);
            
            if (editButton) {
                editButton.click();
                // console.log(`[${config.moduleName}] Clic simulado en el botón de edición para el ID: ${id}`);
            } else {
                console.warn(`[${config.moduleName}] Botón de edición para el ID ${id} no encontrado.`);
            }
        }
    };

    // Llamamos a la función genérica con el callback específico
    ejecutarAccionDesdeURL(config, callbackAccion);
});
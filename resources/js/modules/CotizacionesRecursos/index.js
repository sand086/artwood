import { render } from 'nprogress';
import { showMessage } from '../../Helpers/messageHelper.js';
import { formatearMoneda, desformatearMoneda, renderMoneda, renderPorcentaje } from '../../Helpers/utils.js'; 
import { showInfoModal } from '../../Helpers/infoModalHelper.js';
window.MonedaHelpers = { formatearMoneda, desformatearMoneda };

const config = {
    moduleName: 'CotizacionesRecursos',
    baseUrl: '/cotizacionesrecursos/',
    idField: 'cotizacion_recurso_id',
    formFields: ['cotizacion_analisis_id', 'tipo_recurso_id', 'recurso_id', 'proveedor_id', 'unidad_medida_id', 'precio_unitario', 'porcentaje_ganancia', 'precio_unitario_ganancia', 'cantidad', 'precio_total', 'tiempo_entrega', 'usuario_id', 'estado'],
    moduleForm: 'cotizacionesrecursosForm',
    moduleTable: 'cotizacionesrecursosTable',
    moduleModal: 'cotizacionesanalisisModal',
    parentIdField: 'cotizacion_analisis_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'recursos', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-recurso',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-recurso',
    columns: [
        {
            data: 'proveedor_nombre',
            name: 'proveedor_nombre',
            title: 'Proveedor',
            render: function(data, type, row) {
                if (type === 'display' && row.proveedor_id) {
                    // Construimos la URL para obtener los detalles del proveedor.
                    const url = `/proveedores/${row.proveedor_id}/details`;
                    const title = `Detalles de: ${data}`;

                    // Devolvemos el HTML con el enlace y el icono que activarán el modal.
                    // Usamos la clase 'show-info-modal-trigger' y los atributos data-*
                    return `
                        <a href="#" class="show-info-modal-trigger flex items-center gap-2 hover:underline text-blue-600"
                           data-url="${url}"
                           data-title="${title}">
                            <span>${data || 'N/A'}</span>
                        </a>`;
                }
                return data || 'N/A';
            }
        },
        { data: 'tipo_recurso_nombre', name: 'tipo_recurso_nombre', title: 'Tipo Recurso' },
        { data: 'recurso_nombre', name: 'recurso_nombre', title: 'Recurso' },
        { data: 'unidad_medida_nombre', name: 'unidad_medida_nombre', title: 'Unidad Medida' },
        { data: 'precio_unitario', name: 'precio_unitario', title: 'Precio Unitario', render: renderMoneda },
        { data: 'porcentaje_ganancia', name: 'porcentaje_ganancia', title: '% Ganancia', render: renderPorcentaje }, 
        { data: 'precio_unitario_ganancia', name: 'precio_unitario_ganancia', title: 'Precio Unitario + Ganancia', render: renderMoneda },
        { data: 'cantidad', name: 'cantidad', title: 'Cantidad' },
        { data: 'precio_total', name: 'precio_total', title: 'Precio Total', render: renderMoneda },
        { data: 'tiempo_entrega', name: 'tiempo_entrega', title: 'Tiempo Entrega', 
            render: (data) => {
                return data ? `${data} días` : 'N/A';
            } 
        },
        // { data: 'usuario_nombre', name: 'usuario_nombre', title: 'Usuario' },
        // { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
    initComplete: function() {
        // 'this' aquí es la instancia de BaseModule, por lo que 'this.table' es la DataTable.
        const tableBody = $(this.table.table().body());

        // Usamos delegación de eventos para que funcione con la paginación y búsquedas.
        tableBody.off('click', '.show-info-modal-trigger').on('click', '.show-info-modal-trigger', function(e) {
            e.preventDefault();
            const target = e.currentTarget;
            const url = target.dataset.url;
            const title = target.dataset.title;

            if (url && title) {
                showInfoModal(url, title);
            }
        });
    },
    onEditSuccess: (data) => {
        window.dispatchEvent(new CustomEvent('show-form-recurso'));
    },
    onSaveSuccess: (responseData, formElement) => {
        // Dispara el evento para mostrar el formulario de recurso si es necesario
        window.dispatchEvent(new CustomEvent('hide-form-recurso'));

        // Intenta obtener el valor de 'tiempo_total_analisis' de la respuesta.
        // Es crucial que tu backend retorne este dato en la respuesta JSON.
        const tiempoTotalAnalisis = responseData.tiempo_total_analisis || responseData.data?.tiempo_total_analisis || responseData.registro?.tiempo_total_analisis;

        /**
         * Dispara un evento personalizado para actualizar el tiempo total del análisis.
         * Este evento será escuchado por el formulario de Análisis para actualizar el campo correspondiente
         * y así reflejar el tiempo total del análisis en la interfaz de usuario.
         * Asegúrate de que el backend retorne 'tiempo_total_analisis' en la respuesta JSON
         * para que este evento funcione correctamente.
         * Si 'tiempo_total_analisis' no se encuentra en la respuesta, se mostrará una advertencia en la consola.
         */
        if (tiempoTotalAnalisis !== undefined && tiempoTotalAnalisis !== null) {
            // Si 'tiempo_total_analisis' se encontró, disparamos un evento personalizado.
            // Este evento será escuchado por el formulario de Análisis para actualizar el campo.
            window.dispatchEvent(new CustomEvent('analisis-tiempo-total-actualizado', {
                detail: {
                    tiempoTotal: tiempoTotalAnalisis // Pasa el valor del tiempo total del análisis
                }
            }));
            // console.log(`Evento 'analisis-tiempo-total-actualizado' disparado con tiempo_total_analisis: ${tiempoTotalAnalisis}`);
        } else {
            // Si 'tiempo_total_analisis' no se encontró, mostramos una advertencia en la consola.
            console.warn('tiempo_total_analisis no encontrado en la respuesta del backend para el módulo de CotizacionesRecursos.');
        }

        /**
         * Dispara un evento personalizado para actualizar el costo total del análisis.
         * Este evento será escuchado por el formulario de Análisis para actualizar el campo correspondiente
         * y así reflejar el costo total del análisis en la interfaz de usuario.
         * Asegúrate de que el backend retorne 'costo_total_analisis' en la respuesta JSON
         * para que este evento funcione correctamente.
         * Si 'costo_total_analisis' no se encuentra en la respuesta, se mostrará una advertencia en la consola.
         */
        const costoTotalAnalisis = responseData.costo_total_analisis || responseData.data?.costo_total_analisis || responseData.registro?.costo_total_analisis;
        const costoSubtotalAnalisis = responseData.costo_subtotal_analisis || responseData.data?.costo_subtotal_analisis || responseData.registro?.costo_subtotal_analisis;
        // Verifica si ambos valores existen antes de disparar el evento
        if (costoTotalAnalisis !== undefined && costoTotalAnalisis !== null && 
            costoSubtotalAnalisis !== undefined && costoSubtotalAnalisis !== null) {
            
            window.dispatchEvent(new CustomEvent('analisis-costo-total-actualizado', {
                detail: {
                    costoSubtotal: costoSubtotalAnalisis, // Pasa el valor del costo total del análisis
                    costoTotal: costoTotalAnalisis // Pasa el valor del costo total del análisis
                }
            }));
        } else {
            console.warn('costo_total_analisis no encontrado en la respuesta del backend para el módulo de CotizacionesRecursos.');
        }

        // Mostrar un mensaje de éxito al usuario
        showMessage("success", "Éxito", responseData.message || "Operación completada exitosamente.");
    }
};

const cotizacionesrecursosModule = new BaseModule(config);
cotizacionesrecursosModule.init();

$(document).on('xhr.dt', `#${config.moduleTable}`, function (e, settings, json, xhr) {
    if (json && json.porcentajeGananciaDefault !== undefined && json.porcentajeGananciaDefault !== null) {
        const porcentajeGananciaDefault = json.porcentajeGananciaDefault;
        
        // Disparar un evento global para que Alpine.js en recursos.blade.php lo escuche
        window.dispatchEvent(new CustomEvent('recursos-porcentaje-ganancia-default-actualizado', {
            detail: {
                defaultPorcentaje: porcentajeGananciaDefault
            }
        }));
        // console.log(`Evento 'recursos-porcentaje-ganancia-default-actualizado' disparado con: ${porcentajeGananciaDefault}`);
    } else {
        console.warn('porcentajeGananciaDefault no encontrado en la respuesta AJAX del DataTable de Recursos.');
    }
});

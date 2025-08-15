// resources/js/modules/BaseModule.js
import { createIcons, icons } from "lucide";
createIcons({ icons });

import { showMessage } from "../Helpers/messageHelper";

import {
    sendAjaxRequest,
    handleAjaxError,
    formatearFecha,
    actualizarEstado,
    formatearFechaSinSegundos,
} from "../Helpers/utils";
import { type } from "jquery";

const agregarIcon = "/images/icons/crud/iconos_agregar.svg";

export default class BaseModule {
    constructor(config) {
        this.config = config;
        this.table = null;
        this.baseUrl = config.baseUrl;
        this.parentIdField = config.parentIdField || null; // Parámetro de ID padre
        this.parentIdCurrent = null; // Almacena el ID padre actual
        this.state = { id: "", method: "POST" };
        this.formatearFechaSinSegundos = formatearFechaSinSegundos;
        this.isActivated = false; // Nuevo: Bandera para saber si ya se inicializó
        this.config.formIsInModal = config.formIsInModal !== false; // Default true
        this.config.showFormEventName = config.showFormEventName || null;
        this.config.hideFormEventName = config.hideFormEventName || null;
        this.config.onEditSuccess = config.onEditSuccess || null; // Callback opcional
        this.config.onSaveSuccess = config.onSaveSuccess || null; // Callback opcional
        this.openModalOnLoad = config.openModalOnLoad || false;
        // Vincula el método reloadDataTable al contexto de la instancia si fuera necesario
        // this.reloadDataTable = this.reloadDataTable.bind(this);

        // Itera sobre las columnas
        this.config.columns = this.config.columns.map((col) => {
            // Reemplaza string 'render' por la función correspondiente, si existe
            if (
                typeof col.render === "string" &&
                typeof this[col.render] === "function"
            ) {
                col.render = this[col.render].bind(this);
            }

            // Guarda cualquier callback original en createdCell
            const originalCreatedCell = col.createdCell;

            // Agrega o sobrescribe createdCell para eliminar clases por defecto y aplicar las definidas en className
            col.createdCell = function (td, cellData, rowData, row, colIndex) {
                // Remueve clases automáticas que DataTables agrega para alinear números y fechas
                $(td).removeClass("dt-type-numeric dt-type-date dt-body-right");
                // Aplica las clases definidas en className, si existen
                if (col.className) {
                    $(td).addClass(col.className);
                }
                // Llama al callback original, si está definido
                if (typeof originalCreatedCell === "function") {
                    originalCreatedCell(td, cellData, rowData, row, colIndex);
                }
            };
            return col;
        });
    }

    // Metodo para obtener la URL Ajax con el filtro padre
    getAjaxUrl() {
        let url = this.baseUrl;

        if (this.parentIdField && this.parentIdCurrent) {
            // Añade el parámetro de filtro a la URL
            const separator = url.includes("?") ? "&" : "?";
            url += `${separator}${this.parentIdField}=${this.parentIdCurrent}`;
        }
        // else if (this.parentIdField) {
        //     // Si se requiere un ID padre pero no hay uno, ¿qué hacer?
        //     // Opción 1: Devolver una URL que no devuelva datos (ej: ID inválido)
        //     const separator = url.includes('?') ? '&' : '?';
        //     url += `${separator}${this.parentIdField}=-1`; // O un valor que el backend interprete como "ninguno"
        //     // Opción 2: Devolver null o lanzar error para prevenir la carga
        //     // return null;
        // }
        return url;
    }

    /**
     * Inicializa la tabla del módulo
     */
    initDataTable() {
        const tableSelector = `#${this.config.moduleTable}`;

        // Desvincula listener previo para evitar duplicados
        $(tableSelector).off("click", ".eliminar");

        // Si esperamos un padre y no lo tenemos, no inicializar DataTable aún
        if (this.parentIdField !== null && this.parentIdCurrent === null) {
            console.log(
                `[${this.config.moduleName}] Waiting for parent ID. DataTable initialization deferred.`
            );
            // Opcionalmente, podrías mostrar un mensaje en lugar de la tabla
            // $(tableSelector).html('<p class="text-center text-gray-500 p-4">Seleccione un registro principal para ver los detalles.</p>');
            return; // Salir temprano
        }
        // Si la tabla ya está inicializada, la destruimos y limpiamos
        // Esto es útil si el módulo se inicializa varias veces o si se cambia el ID padre
        if ($.fn.DataTable.isDataTable(tableSelector)) {
            $(tableSelector).DataTable().clear().destroy();
            $(`${tableSelector} thead`).remove();
            $(tableSelector).empty();
        }

        const ajaxUrl = this.getAjaxUrl();
        // Si la URL es null (porque falta el ID padre), no continuar.
        if (!ajaxUrl && this.parentIdField) {
            console.error(
                `[${this.config.moduleName}] Cannot initialize DataTable without a valid parent ID.`
            );
            // Podrías mostrar un mensaje de error aquí
            return; // No continuar si la URL es inválida por falta de ID padre
        }

        const columns = this.config.columns;

        const buttons = this.config.buttons || [
            {
                extend: "copy",
                text: "COPIAR",
                titleAttr: "Copiar en portapapeles",
                className: "art-btn-secondary text-xs",
            },
            {
                extend: "excelHtml5",
                text: "EXCEL",
                titleAttr: "Exportar a Excel",
                className: "art-btn-secondary text-xs",
            },
            {
                extend: "pdfHtml5",
                text: "PDF",
                titleAttr: "Exportar a PDF",
                className: "art-btn-secondary text-xs",
            },
            {
                extend: "colvis",
                text: "Columnas",
                titleAttr: "Mostrar/Ocultar Columnas",
                className: "art-btn-secondary text-xs relative",
                columnText: function (dt, i, title) {
                    const visible = dt.column(i).visible();
                    return `<label class="flex items-center gap-2 m-0 p-0 cursor-pointer">
                              <input type="checkbox" class="form-checkbox pointer-events-none h-4 w-4 text-blue-600" ${
                                  visible ? "checked" : ""
                              } />
                              <span>${title}</span>
                            </label>`;
                },
                // Opcional: cambiar la disposición de la colección si lo deseas
            },
            {
                text: `
                    <span class="flex items-center gap-2">
                        <img src="${agregarIcon}" alt="Agregar" class="w-4 h-4" />
                        <span>Agregar</span>
                    </span>
                `,
                titleAttr: "Agregar",
                className:
                    "px-4 py-2_5 border border-primary rounded-md text-primary font-semibold text-xs transition-all duration-300 hover:bg-primary hover:text-white",
                action: () => {
                    // Asegurando el estado inicial
                    this.state = { id: "", method: "POST" };

                    const modalElement = document.getElementById(
                        this.config.moduleModal
                    );
                    const form = document.getElementById(
                        this.config.moduleForm
                    );

                    // if (modalElement) {
                    //     // Limpia el data-attribute (buena práctica)
                    //     modalElement.dataset.currentId = '';

                    //     // Despacha un evento para que Alpine lo escuche
                    //     console.log(`[${this.config.moduleName}] Dispatching update-alpine-tabs event for ADD`);
                    //     modalElement.dispatchEvent(new CustomEvent('update-alpine-tabs', {
                    //         detail: { isEditing: false, tab: this.config.targetTab },
                    //         bubbles: true // Permitir que el evento burbujee por si el listener está en un padre
                    //     }));

                    // } else {
                    //      console.error(`[${this.config.moduleName}] Modal element #${this.config.moduleModal} not found for ADD.`);
                    // }

                    // Limpia los campos del formulario
                    if (form) {
                        form.reset();
                        // Configura el formulario para modo 'POST' (aunque reset() suele limpiar esto)
                        $(form).attr({
                            "data-id": "",
                            "data-type": "POST",
                            method: "POST", // Asegurar método POST por defecto
                            action: this.baseUrl,
                        });
                    } else {
                        console.error(
                            `[${this.config.moduleName}] Form element #${this.config.moduleForm} not found for ADD.`
                        );
                        return; // No continuar si no hay formulario
                    }
                    // Muestra el modal
                    if (this.config.formIsInModal) {
                        // Caso Modal
                        if (modalElement) {
                            modalElement.dataset.currentId = ""; // Limpia data-attribute
                            // console.log(`[${this.config.moduleName}] Dispatching update-alpine-tabs event for ADD (Modal)`);
                            modalElement.dispatchEvent(
                                new CustomEvent("update-alpine-tabs", {
                                    detail: {
                                        isEditing: false,
                                        tab: this.config.targetTab,
                                    },
                                    bubbles: true,
                                })
                            );
                            window.Helpers.showModal(this.config.moduleModal);
                        } else {
                            console.error(
                                `[${this.config.moduleName}] Modal element #${this.config.moduleModal} not found, but formIsInModal is true.`
                            );
                        }
                    } 
                    // else {
                        // Caso Inline (disparar evento)
                        if (this.config.showFormEventName) {
                            console.log(`[${this.config.moduleName}] Dispatching event '${this.config.showFormEventName}' for ADD (Inline)`);
                            window.dispatchEvent(
                                new CustomEvent(this.config.showFormEventName, {
                                    detail: { isEditing: false }, // Pasamos info útil
                                })
                            );
                        } else {
                            if( !this.config.formIsInModal ){
                                console.warn(
                                    `[${this.config.moduleName}] formIsInModal is false, but no showFormEventName defined in config.`
                                );
                            }
                        }
                    // }

                    // Muestra el modal
                    window.Helpers.showModal(this.config.moduleModal);
                },
            },
        ];

        this.table = $(tableSelector).DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            scrollCollapse: true,
            scrollY: "75vh",
            scrollX: "75vw",
            ajax: { url: ajaxUrl, type: "GET", async: true },
            columns,
            language: { url: "/lang/datatables/es-ES.json" },
            lengthMenu: [
                [10, 20, 50, -1],
                [10, 20, 50, "Todos"],
            ],
            oLanguage: {
                oPaginate: {
                    sFirst: '<i data-lucide="chevrons-left" class="w-4 h-4"></i>',
                    sPrevious:
                        '<i data-lucide="chevron-left" class="w-4 h-4"></i>',
                    sNext: '<i data-lucide="chevron-right" class="w-4 h-4"></i>',
                    sLast: '<i data-lucide="chevrons-right" class="w-4 h-4"></i>',
                },
            },
            dom: `
            <"sm:flex sm:items-center sm:justify-between mb-4"
                <"flex flex-col gap-2"
                    <"flex items-center gap-4"B>
                    <"flex items-center mt-5 gap-4"l>
                >
                <"flex items-center justify-end"f>
            >
            <"overflow-x-auto"rt>
            <"sm:flex sm:items-center sm:justify-between mt-4"
                <"text-sm text-gray-700"i>
                <"flex items-center justify-end"p>
            >
        `,
            buttons,
            headerCallback: (thead, data, start, end, display) => {
                $(thead)
                    .find("th")
                    .each((index, th) => {
                        const colConfig = this.config.columns[index];
                        const headerClass =
                            colConfig &&
                            colConfig.headerClass &&
                            colConfig.headerClass.trim() !== ""
                                ? colConfig.headerClass
                                : "text-left";
                        $(th).addClass(headerClass);
                    });
            },

            // Llamamos a createIcons en la primera carga
            initComplete: function () {
                createIcons({ icons });
            },
            // Llamamos a createIcons después de cada recarga
            drawCallback: () => {
                createIcons({ icons });
            },
            initComplete: function (settings, json) {
                const tableBody = $(tableSelector);

                // Listener para toggles de estado
                tableBody
                    .off("change", ".toggle-estado")
                    .on("change", ".toggle-estado", async (e) => {
                        const checkbox = e.currentTarget;
                        const id = checkbox.dataset.id;
                        const nuevoEstado = checkbox.checked ? "A" : "I";

                        // Construimos la URL de forma segura:
                        // Si this.baseUrl existe, nos aseguramos de que termine SIN slash
                        // y luego le agregamos /{id}. En caso contrario, usamos la ruta fija.
                        const base = this.baseUrl
                            ? this.baseUrl.replace(/\/$/, "") // quita slash final si lo tiene
                            : "";
                        const url = base ? `${base}/${id}` : `/api/areas/${id}`;

                        try {
                            sendAjaxRequest(
                                `${base}/${id}`,
                                'PUT', // Laravel lo necesita como POST
                                {
                                    method: 'PUT',
                                    only_status: true,
                                    estado: nuevoEstado,
                                },
                                (res) => {
                                    this.table.ajax.reload(null, false);
                                    showMessage( "success", "Éxito", res.message || 'Estado actualizado' );
                                },
                                (err) => {
                                    checkbox.checked = !checkbox.checked;
                                    showMessage('error', 'Error', err.message || 'Error actualizando estado');
                                }
                            );

                            // Refresca solo la tabla sin resetear paginación
                            this.table.ajax.reload(null, false);
                        } catch (err) {
                            // Revertir el toggle en caso de error
                            checkbox.checked = !checkbox.checked;
                            showMessage("error", "Error", err.message);
                        }
                    });
                
                if (typeof this.config.initComplete === 'function') {
                    this.config.initComplete.call(this, settings, json);
                }

                createIcons({ icons });
            }.bind(this),
        });

        // ELIMINAR ELEMENTO
        $(tableSelector).on("click", ".eliminar", (e) => {
            e.preventDefault();
            const url = $(e.currentTarget).data("url");
            const confirmMessage =
                $(e.currentTarget).data("confirm") || "¿Estás seguro?";

            // alerta de confirmación usando tu helper
            showMessage(
                "confirm",
                confirmMessage,
                "Esta acción no se puede deshacer",
                {
                    confirmText: "Sí, eliminar",
                    cancelText: "Cancelar",
                    useAnimatedIcon: false, //  GIF animado
                }
            ).then((result) => {
                if (result.isConfirmed) {
                    //  confirma la acción, se envía la petición DELETE
                    sendAjaxRequest(
                        url,
                        "DELETE",
                        null,
                        (response) => {
                            // Recarga la tabla después de eliminar
                            this.table.ajax.reload();

                            // Normaliza la respuesta para manejar ambos formatos (plano y anidado)
                            const responseData = response.data || response;
                            // Muestra alerta de éxito
                            showMessage(
                                "success",
                                "Éxito",
                                responseData.message
                            );
                        },
                        handleAjaxError
                    );
                }
            });
        });
    }

    /**
     * Método para gestionar el evento de actualización del formulario
     * 
     * @param {*} data 
     * @param {*} type 
     * @param {*} row 
     * @returns 
     */
    renderEstado(data, type, row) {
        if (type === "display") {
            const isChecked = row.estado === "A";
            const id = row[this.config.idField]; // Usar el ID del padre o el ID del recurso
            // añadimos data-id y clase toggle-estado
            return `
      <label class="relative inline-flex items-center cursor-pointer">
        <input
          type="checkbox"
          data-id="${id}"
          class="toggle-estado sr-only"
          ${isChecked ? "checked" : ""}
        >
        <div class="w-11 h-6 ${isChecked ? "art-bg-secondary" : "bg-gray-200"}
                     rounded-full transition-colors duration-200">
          <div class="absolute left-1 top-1 w-4 h-4 bg-white rounded-full
                       transition-transform duration-200 transform
                       ${isChecked ? "translate-x-5" : ""}">
          </div>
        </div>
      </label>
    `;
        }
        return data;
    }

    /**
     * Inicializa el formulario y la tabla del módulo
     */
    initForm() {
        // Si esperamos un padre y no lo tenemos, no inicializar listeners del form aún
        // (Aunque los listeners actuales dependen de la tabla, es buena práctica)
        if (
            this.parentIdField &&
            this.parentIdCurrent === null &&
            !this.isActivated
        ) {
            console.log(
                `[${this.config.moduleName}] Waiting for parent ID. Form initialization deferred.`
            );
            return;
        }

        const { moduleForm, moduleTable, formFields, baseUrl, moduleModal } =
            this.config;
        const formSelector = $(`#${moduleForm}`);
        const tableSelector = $(`#${moduleTable}`);

        // Desvincula listeners previos para evitar duplicados
        tableSelector.off("click", ".editar");
        formSelector.off("submit");

        // EVENTO: Clic en Botón Editar
        tableSelector.on("click", ".editar", (e) => {
            e.preventDefault();
            const url = $(e.currentTarget).data("url");

            sendAjaxRequest(
                url,
                "GET",
                null,
                (response) => {
                    // Normaliza la respuesta: usa response.data si existe, si no, usa la respuesta completa.
                    const data = response.data || response;
                    const modalElement = document.getElementById(moduleModal); // Obtener el elemento del modal
                    if (!modalElement) {
                        console.error(
                            `[${this.config.moduleName}] Modal element #${moduleModal} not found! Cannot proceed with edit.`
                        );
                        handleAjaxError({
                            // Simula un error para detener el flujo si el modal no existe
                            responseJSON: {
                                message: `Modal #${moduleModal} no encontrado.`,
                            },
                        });
                        return; // Detener ejecución
                    }
                    // console.log("Datos recibidos para editar:", data); // Útil para depurar la estructura de data

                    // Actualiza estado interno del módulo
                    this.state.id = data[this.config.idField || ""];
                    this.state.method = "PUT";

                    // Configura el formulario para modo 'PUT'
                    formSelector.attr({
                        "data-id": this.state.id,
                        "data-type": "PUT",
                        method: "PUT",
                        action: baseUrl + this.state.id,
                    });
                    // console.info(`[${moduleModal}] Form configured for EDIT: ID=${this.state.id}, Method=PUT`);

                    // Actualiza el data-attribute
                    // modalElement.dataset.currentId = this.state.id;

                    // Despacha el evento ANTES del setTimeout o justo al inicio del mismo
                    // console.log(`[${this.config.moduleName}] Dispatching update-alpine-tabs event for EDIT`);
                    modalElement.dispatchEvent(
                        new CustomEvent("update-alpine-tabs", {
                            detail: {
                                isEditing: true,
                                tab: this.config.targetTab,
                                data: data
                            },
                            bubbles: true,
                        })
                    );

                    // Rellena cada campo definido en formFields con los datos
                    setTimeout(() => {
                        this.config.formFields.forEach((fieldName) => {
                            // Si el campo actual es el ID del padre, no intentes buscarlo en el formulario,
                            // ya que se gestiona a través de `this.parentIdCurrent`.
                            if (fieldName === this.parentIdField) {
                                return; // Saltar a la siguiente iteración
                            }

                            const fieldElement = formSelector.find(
                                `[name="${fieldName}"]`
                            ); // Buscar por atributo 'name'

                            if (fieldElement.length) {
                                // Verificar si el elemento existe
                                const recordValue = data[fieldName];
                                const valueToSet =
                                    recordValue !== null &&
                                    recordValue !== undefined
                                        ? recordValue
                                        : ""; // Valor limpio

                                // *** Cambio Clave: Diferenciar Selects Personalizados ***
                                if (
                                    fieldElement.is("select") &&
                                    fieldElement.attr("data-table")
                                ) {
                                    // Es nuestro componente form-select (identificado por tener data-table)
                                    // console.log(`[${this.config.moduleName}] Dispatching 'set-value' for custom select [name="${fieldName}"] with value:`, valueToSet);
                                    // Disparamos el evento personalizado en el elemento DOM nativo
                                    fieldElement[0].dispatchEvent(
                                        new CustomEvent("set-value", {
                                            detail: { value: valueToSet },
                                            bubbles: true, // Permitir que burbujee si es necesario
                                        })
                                    );
                                } else if (fieldElement.is(":checkbox")) {
                                    // Manejo para checkboxes
                                    const checkedValue =
                                        String(valueToSet).toUpperCase(); // Convertir a string y mayúsculas para comparación robusta
                                    fieldElement.prop(
                                        "checked",
                                        checkedValue === "A" ||
                                            checkedValue === "1" ||
                                            checkedValue === "TRUE"
                                    );
                                    // Disparar 'change' por si hay lógica asociada
                                    fieldElement.trigger("change");
                                } else if (fieldElement.is(":radio")) {
                                    // Manejo para radios
                                    formSelector
                                        .find(
                                            `[name="${fieldName}"][value="${valueToSet}"]`
                                        )
                                        .prop("checked", true);
                                    // Disparar 'change' en el grupo
                                    formSelector
                                        .find(`[name="${fieldName}"]`)
                                        .trigger("change");
                                } else if (
                                    fieldElement.attr("type") === "date" ||
                                    fieldElement.attr("type") ===
                                        "datetime-local"
                                ) {
                                    // Formatear fechas si es necesario
                                    try {
                                        if (valueToSet) {
                                            const date = new Date(valueToSet);
                                            let formattedValue = valueToSet;
                                            if (
                                                fieldElement.attr("type") ===
                                                "date"
                                            ) {
                                                // Formato YYYY-MM-DD
                                                formattedValue = date
                                                    .toISOString()
                                                    .split("T")[0];
                                            } else {
                                                // Formato YYYY-MM-DDTHH:mm (sin segundos)
                                                formattedValue = date
                                                    .toISOString()
                                                    .slice(0, 16);
                                            }
                                            fieldElement.val(formattedValue);
                                        } else {
                                            fieldElement.val(""); // Limpiar si el valor es nulo/vacío
                                        }
                                    } catch (e) {
                                        console.warn(
                                            `[${this.config.moduleName}] Could not format date for field [name="${fieldName}"]:`,
                                            valueToSet,
                                            e
                                        );
                                        fieldElement.val(valueToSet); // Usar valor original si falla el formato
                                    }
                                    fieldElement
                                        .trigger("input")
                                        .trigger("change"); // Disparar eventos
                                } else {
                                    // Para inputs normales (text, number, hidden, textarea, etc.) y selects estándar (no personalizados)
                                    // console.log(`[${this.config.moduleName}] Setting value for standard input [name="${fieldName}"] with value:`, valueToSet);
                                    fieldElement.val(valueToSet);
                                    // Disparar eventos 'input' y 'change' puede ser útil si hay listeners JS
                                    fieldElement
                                        .trigger("input")
                                        .trigger("change");
                                }
                            } else {
                                console.warn(
                                    `[${this.config.moduleName}] Field element [name="${fieldName}"] not found in form #${moduleForm}.`
                                );
                            }
                        });

                        // Llamar al callback afterLoadData si está definido en la configuración
                        if (typeof this.config.afterLoadData === "function") {
                            // console.log(`[${this.config.moduleName}] Calling afterLoadData callback.`);
                            // Pasamos los datos completos y el selector del formulario
                            this.config.afterLoadData(data, formSelector);
                        }
                        // console.log(data.nombre);
                        // $("#nombre").val(data.nombre);

                        // actualizarEstado(data.estado);
                        // $("#fecha_registro").val(
                        //     formatearFecha(data.fecha_registro)
                        // );
                        // $("#fecha_actualizacion").val(
                        //     formatearFecha(data.fecha_actualizacion)
                        // );

                        // console.log(this.state.method);
                        if (this.state.method === "PUT") {
                            // Ocultamos los campos por defecto y mostramos un botón para cambiar la contraseña
                            $(".password-fields").hide();
                            $("#btn-cambiar-password").show();
                            $("#btn-cambiar-password")
                                .off("click")
                                .on("click", function () {
                                    // Al hacer clic, mostramos los campos y agregamos el atributo required
                                    $(".password-fields").show();
                                    $("#password, #password_confirmation").attr(
                                        "required",
                                        true
                                    );
                                    // Opcional: ocultar el botón una vez mostrado el formulario de contraseña
                                    $(this).hide();
                                });
                        } else {
                            // En modo creación, mostramos los campos de contraseña y los marcamos como requeridos
                            $(".password-fields").show();
                            $("#password, #password_confirmation").attr(
                                "required",
                                true
                            );
                            $("#btn-cambiar-password").hide();
                        }

                        // Solo si es un modulo padre
                        if (!this.parentIdField) {
                            this.updateSelectedRegister(
                                moduleModal,
                                this.state.id
                            );
                        }
                        // Muestra el modal
                        // window.Helpers.showModal(moduleModal);
                        if (this.config.formIsInModal) {
                            // Caso Modal
                            if (modalElement) {
                                // El evento update-alpine-tabs ya se despachó antes
                                window.Helpers.showModal(moduleModal);
                            } else {
                                console.error(
                                    `[${this.config.moduleName}] Modal element #${moduleModal} not found for EDIT, but formIsInModal is true.`
                                );
                            }
                        } else {
                            // Caso Inline (disparar evento)
                            if (this.config.showFormEventName) {
                                // console.log(`[${this.config.moduleName}] Dispatching event '${this.config.showFormEventName}' for EDIT (Inline)`);
                                window.dispatchEvent(
                                    new CustomEvent(
                                        this.config.showFormEventName,
                                        {
                                            detail: {
                                                isEditing: true,
                                                data: data,
                                            }, // Pasamos info útil
                                        }
                                    )
                                );
                            } else {
                                console.warn(
                                    `[${this.config.moduleName}] formIsInModal is false, but no showFormEventName defined in config for edit.`
                                );
                            }
                        }

                        if (typeof this.config.onEditSuccess === "function") {
                            // console.log(`[${this.config.moduleName}] Calling onEditSuccess callback.`);
                            this.config.onEditSuccess(data, formSelector);
                        }
                    }, 100);
                },
                handleAjaxError
            );
        });

        // EVENTO: Envío de formulario (Crear o Actualizar)
        formSelector.on("submit", (e) => {
            e.preventDefault();

            const form = document.getElementById(moduleForm);
            const formData = new FormData(form);
            // Si el modulo tiene un padre, agrega el ID del padre actual al FormData
            if (
                this.parentIdField &&
                this.parentIdCurrent &&
                !formData.has(this.parentIdField)
            ) {
                formData.append(this.parentIdField, this.parentIdCurrent);
                // console.log(`[${this.config.moduleName}] Appending parent ID (${this.parentIdField}=${this.parentIdCurrent}) to form data.`);
            }
            // Si estamos en modo PUT, se concatena el ID
            const actionUrl =
                this.state.method === "PUT" && this.state.id
                    ? `${baseUrl}${this.state.id}`
                    : baseUrl;

            // Ensure _method is correctly set for PUT operations
            if (this.state.method === "PUT") {
                formData.append("_method", "PUT");
            }

            // Envío AJAX
            sendAjaxRequest(
                actionUrl,
                "POST",
                formData,
                (response) => {
                    // Normaliza la respuesta: usa response.data si existe, si no, usa la respuesta completa.
                    const responseData = response.data || response;
                    const wasCreateOperation = this.state.method === "POST";
                    
                    let savedRecordId;
                    // Determinar el ID del registro guardado
                    // Si fue una operación de creación, buscamos el ID en la respuesta
                    // Si fue una operación de actualización, usamos el ID del estado actual
                    if (wasCreateOperation) {
                        if (responseData.registro) {
                            savedRecordId =
                                responseData.registro[this.config.idField];
                        } else if (responseData[this.config.idField]) {
                            savedRecordId = responseData[this.config.idField];
                        } else {
                            console.error(
                                `[${this.config.moduleName}] No ID found in response data for new record.`
                            );
                        }
                    } else this.state.id; // Use existing ID for updated records

                    // Action 1: Reload main table of the current module
                    if (this.table) {
                        this.table.ajax.reload();
                    }

                    // Action 2: Show success message
                    showMessage("success", "Éxito", responseData.message);

                    // If the response contains a registro, we can use it to call onSaveSuccess
                    if (typeof this.config.onSaveSuccess === "function") {
                        this.config.onSaveSuccess(responseData, formSelector); // Pasa los datos de respuesta y el elemento del formulario
                    }

                    // Action 3: Handle modal/form visibility, tab activation, and form state
                    if (this.config.closeModalOnSave === false) {
                        // --- Modal/Form STAYS OPEN ---
                        // 3.1. If this module is a PARENT, notify its child modules (tabs) to update.
                        // This triggers `register-selected` event, causing child DataTables to init/reload.
                        if (!this.parentIdField && savedRecordId) {
                            form.append(this.config.idField, savedRecordId); // Add currentId to form data
                            this.updateSelectedRegister(
                                this.config.moduleModal,
                                savedRecordId
                            );
                        }

                        // 3.2. Activate the target tab within the current module's modal/form (if applicable).
                        // This is for AlpineJS or similar tab management within the modal.
                        const modalElement = document.getElementById(
                            this.config.moduleModal
                        );
                        if (
                            modalElement &&
                            this.config.targetTab &&
                            savedRecordId
                        ) {
                            // console.log(`[${this.config.moduleName}] Dispatching update-alpine-tabs to switch to tab '${this.config.targetTab}' after save.`);
                            modalElement.dispatchEvent(
                                new CustomEvent("update-alpine-tabs", {
                                    detail: {
                                        isEditing: true, // We are now effectively "editing" the saved record
                                        tab: this.config.targetTab,
                                        currentId: savedRecordId,
                                    },
                                    bubbles: true,
                                })
                            );
                        }

                        // 3.3. Handle form state and content (reset or keep for editing).
                        if (this.config.resetFormOnSave === true) {
                            // Reset form for a new entry
                            form.reset();
                            this.state = { id: "", method: "POST" };
                            formSelector.attr({
                                "data-id": "",
                                "data-type": "POST",
                                method: "POST",
                                action: this.baseUrl,
                            });
                        } else {
                            // resetFormOnSave is false: keep form populated
                            if (wasCreateOperation && savedRecordId) {
                                // If it was a 'create', update form's state to 'edit' mode for the new record.
                                this.state.id = savedRecordId;
                                this.state.method = "PUT";
                                formSelector.attr({
                                    "data-id": savedRecordId,
                                    "data-type": "PUT",
                                    method: "PUT", // This is for Alpine/JS state, actual form method is POST
                                    action: `${this.baseUrl}${savedRecordId}`,
                                });
                            }
                            // If it was an 'update', state and form attributes are already correct.
                            // Data remains in the form, reflecting the saved state.
                        }
                    } else {
                        // --- Modal/Form CLOSES or HIDES --- (closeModalOnSave is true or default)
                        if (this.config.closeModalOnSave !== false) {
                            window.Helpers.hideModal(this.config.moduleModal);
                        }
                        // Reset form if configured (common when closing/hiding)
                        if (this.config.resetFormOnSave !== false) {
                            // Default is true, so reset
                            form.reset();
                        }
                        // Always reset state for the next "Add" operation when modal closes/form hides
                        this.state = { id: "", method: "POST" };
                        formSelector.attr({
                            "data-id": "",
                            "data-type": "POST",
                            method: "POST",
                            action: this.baseUrl,
                        });
                    }

                    // Action 4: Handle window close (if applicable)
                    if (this.config.windowCloseSave) {
                        if (window.opener && this.config.windowCloseSave) {
                            // Leer el targetSelectId de la URL del popup
                            const urlParams = new URLSearchParams(window.location.search);
                            const targetSelectId = urlParams.get('targetSelectId');

                            // Obtenemos los campos de valor y etiqueta del registro guardado
                            const newRecord = responseData.registro;
                            const valueField = this.config.idField;

                            window.opener.postMessage(
                                {
                                    // Enviar mensaje a la ventana padre
                                    action: 'record-created-in-popup', // Acción estandarizada
                                    targetSelectId: targetSelectId, // El select a actualizar
                                    registro: newRecord,
                                    valueField: valueField, // Campo para el valor de la opción
                                },
                                window.opener.location.origin
                            );
                        } else {
                            console.warn(
                                `[${this.config.moduleName}] No opener found or windowCloseSave is false.`
                            );
                        }
                        window.close(); // Cerrar la ventana actual
                    }
                },
                handleAjaxError
            );
        });
    }

    /**
     * Activa el módulo (usualmente llamado por un evento del padre)
     * @param {string|number} parentId El ID del registro padre seleccionado.
     */
    activate(parentId) {
        // console.log(`[${this.config.moduleName}] Activating module...`);
        if (!this.parentIdField) {
            console.warn(
                `[${this.config.moduleName}] activate() called but module does not depend on a parent.`
            );
            return;
        }

        // Si el ID del padre es el mismo, podríamos solo recargar la tabla
        if (this.isActivated && this.parentIdCurrent === parentId) {
            // console.log(`[${this.config.moduleName}] Parent ID ${parentId} re-selected. Reloading data.`);
            this.reloadDataTable();
            return;
        }

        // console.log(`[${this.config.moduleName}] Activating with parent ID: ${parentId}...`);
        this.parentIdCurrent = parentId;
        this.isActivated = true; // Marcar como activado

        // Ahora sí, inicializar las partes dependientes
        this.initDataTable(); // Inicializa o reinicializa la tabla con el nuevo ID
        this.initForm(); // Inicializa o reinicializa los listeners del formulario
    }

    /**
     * Recarga los datos de la DataTable.
     */
    reloadDataTable() {
        if (this.table) {
            const newUrl = this.getAjaxUrl();
            if (newUrl) {
                this.table.ajax.url(newUrl).load(null, false); // false para no resetear paginación
                console.log(
                    `[${this.config.moduleName}] DataTable reloaded with URL: ${newUrl}`
                );
            } else {
                console.warn(
                    `[${this.config.moduleName}] Could not reload DataTable, invalid URL generated (maybe missing parent ID?). Clearing table.`
                );
                // Si no hay URL válida (ej. se deseleccionó el padre), limpia la tabla
                this.table.clear().draw();
            }
        } else if (this.isActivated) {
            // Si está activado pero la tabla no existe (raro), intenta inicializarla
            console.warn(
                `[${this.config.moduleName}] reloadDataTable() called but table not initialized, attempting to initialize.`
            );
            this.initDataTable();
        } else {
            console.warn(
                `[${this.config.moduleName}] reloadDataTable() called but module not activated yet.`
            );
        }
    }

    /**
     * Manejador para el evento de selección del padre.
     * @param {CustomEvent} event Evento con detail.registroId
     */
    handleParentSelection(event) {
        // Opcional: Verificar si el evento proviene del contenedor/módulo padre esperado
        // if (event.detail.parentModule !== this.config.expectedParentModule) return;
        // console.log(`[${this.config.moduleName}] Parent selection event received: ${event.detail.registroId}`);
        const parentId = event.detail.registroId;
        if (this.parentIdField) {
            // Solo si este módulo espera un padre
            if (parentId) {
                this.activate(parentId);
            } else {
                // Si el ID del padre es nulo/inválido, desactivar/limpiar el módulo hijo
                //  console.log(`[${this.config.moduleName}] Parent deselected or invalid ID received. Deactivating/Clearing.`);
                this.parentIdCurrent = null;
                // this.isActivated = false; // Podrías resetear esto si quieres que se reactive completamente
                if (this.table) {
                    this.table.clear().draw(); // Limpia la tabla
                }
                // Opcional: Deshabilitar botones/formularios del hijo
                //  $(`#${this.config.moduleForm} :input`).prop('disabled', true);
                // Considera deshabilitar el botón "Agregar" del hijo también
                // $(`#${this.config.moduleTable}_wrapper .dt-buttons button:contains('Agregar')`).prop('disabled', true);
            }
        }
    }

    /**
     * Inicializa el módulo. Ahora escucha por activación si depende de un padre.
     */
    init() {
        // Si este módulo depende de un padre, no inicializa tabla/form, solo escucha.
        if (this.parentIdField) {
            // console.log(`[${this.config.moduleName}] Initialization deferred. Waiting for 'register-selected' event.`);
            // Escucha el evento global que dispara el padre
            window.addEventListener(
                "register-selected",
                this.handleParentSelection.bind(this)
            );
            // Opcional: Deshabilitar controles hasta activación
            // $(`#${this.config.moduleForm} :input`).prop('disabled', true);
            // $(`#${this.config.moduleTable}_wrapper .dt-buttons button:contains('Agregar')`).prop('disabled', true); // Deshabilitar botón Agregar
        } else {
            // Si es un módulo principal (sin dependencia padre), inicializa todo ahora.
            // console.log(`[${this.config.moduleName}] Initializing as a primary module.`);
            this.isActivated = true; // Marcar como activado de inmediato
            this.initDataTable();
            this.initForm();
            if (this.openModalOnLoad) {
                // Abrir la modal si openModalOnLoad es true
                // window.Helpers.toggleModal(this.moduleModal);
                window.Helpers.showModal(this.config.moduleModal);
            }
        }
    }

    // Función que se llama al seleccionar un registro o al guardar/crear
    updateSelectedRegister(contenedorId, registroId) {
        // console.info(`[${this.config.moduleName}] Updating selected register ID: ${registroId}`);
        const container = document.getElementById(contenedorId);
        if (container) {
            const currentId = container.getAttribute("data-current-id");
            // console.info(`[${this.config.moduleName}] Current ID in container: ${currentId}`);
            // Solo actualiza y dispara el evento si el ID realmente cambió o no estaba establecido
            if (currentId !== registroId?.toString()) {
                // Usar ?. para manejar registroId nulo/undefined
                // console.info(`[${this.config.moduleName}] Parent register ID changed to: ${registroId}`);
                container.setAttribute("data-current-id", registroId ?? ""); // Guardar string vacío si es nulo

                // Disparar un evento personalizado para notificar a los módulos hijos
                const event = new CustomEvent("register-selected", {
                    detail: {
                        registroId: registroId, // Pasa el ID (puede ser null si se deselecciona)
                        parentModule: this.config.moduleName, // Opcional: Identifica qué módulo disparó
                    },
                });
                window.dispatchEvent(event);
            }
        } else {
            // No es necesariamente un error si el contenedor no se usa para esto
            // console.warn(`Contenedor ${contenedorId} no encontrado para guardar data-current-id.`);
            // AUNQUE el contenedor no exista, igual debemos notificar a los hijos
            console.info(
                `[${this.config.moduleName}] Notifying children of selected register ID: ${registroId}`
            );
            const event = new CustomEvent("register-selected", {
                detail: {
                    registroId: registroId,
                    parentModule: this.config.moduleName,
                },
            });
            window.dispatchEvent(event);
        }
    }
}

import Swal from "sweetalert2";
import axios from "axios";

/**
 * Muestra un mensaje de error en una alerta de SweetAlert2
 * @param {object} error Objeto de error
 */
export function handleAjaxError(error) {
    if (error.response && error.response.data && error.response.data.message) {
        Swal.fire("Error", error.response.data.message, "error");
    } else if (error.message) {
        Swal.fire("Error", error.message, "error");
    } else {
        Swal.fire("Error", "Ocurrió un error inesperado.", "error");
    }
}

/**
 * Envía una petición AJAX al servidor
 * @param {string} url URL de la petición
 * @param {string} method Método HTTP
 * @param {object} data Datos a enviar
 * @param {function} successCallback Función a ejecutar si la petición es exitosa
 * @param {function} errorCallback Función a ejecutar si la petición falla
 */
export function sendAjaxRequest(
    url,
    method,
    data,
    successCallback,
    errorCallback
) {
    const headers = {
        "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content"), // Usar optional chaining por si el meta tag no existe
    };

    // Si data NO es FormData, y no se ha especificado un Content-Type, se asume json.
    // Si data ES FormData, NO establecemos Content-Type aquí; Axios lo manejará.
    if (!(data instanceof FormData)) {
        headers["Content-Type"] = "application/json";
    }

    axios({
        url: url,
        method: method,
        data: data,
        headers: headers,
    })
        .then(successCallback)
        .catch(errorCallback);
}

/**
 * Formatea una fecha en formato ISO a un formato dd-mm-YYYY H:m:s
 * @param {string} fechaISO Fecha en formato ISO
 * @returns {string} Fecha formateada
 */
export function formatearFecha(fechaISO) {
    if (!fechaISO) return "";

    const fecha = new Date(fechaISO);
    const anio = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const dia = String(fecha.getDate()).padStart(2, "0");
    const hora = String(fecha.getHours()).padStart(2, "0");
    const minutos = String(fecha.getMinutes()).padStart(2, "0");
    const segundos = String(fecha.getSeconds()).padStart(2, "0");

    return `${anio}-${mes}-${dia}T${hora}:${minutos}:${segundos}`;
}

/**
 * Formatea una fecha en formato ISO a un formato dd-mm-YYYY H:m
 * @param {string} fechaISO Fecha en formato ISO
 * @returns {string} Fecha formateada dd-mm-YYYY H:m
 */
export function formatearFechaSinSegundos(fechaISO) {
    if (!fechaISO) return "";

    const fecha = new Date(fechaISO);
    const anio = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const dia = String(fecha.getDate()).padStart(2, "0");
    const hora = fecha.getHours();
    const minutos = fecha.getMinutes();

    return `${dia}-${mes}-${anio} ${hora}:${minutos}`;
}

/**
 * Actualiza el campo de estado y su texto en el formulario
 * @param {string} estado Estado del registro
 */
export function actualizarEstado(estado = "A") {
    const estadoInput = document.querySelector('input[name="estado"]');
    const estadoTextoInput = document.querySelector(
        'input[name="estado-texto"]'
    );
    // asignacion de valor
    estadoInput.value = estado;
    // asignacion de texto
    if (estado === "A" || estado === "") {
        estadoTextoInput.value = "ACTIVO";
    } else if (estado === "I") {
        estadoTextoInput.value = "INACTIVO";
    } else if (estado === "E") {
        estadoTextoInput.value = "ELIMINADO";
    } else {
        estadoTextoInput.value = ""; // Valor por defecto o en caso de otro valor
    }
}

/**
 * Abre una nueva ventana con la URL y parámetros especificados
 * @param {string} url URL a abrir
 * @param {string|object} [params] Parámetros a añadir a la URL. Puede ser un string (ej: '?key=value') o un objeto ({ key: 'value' }).
 * @param {string} [features] String de características de la ventana (ej: 'width=600,height=400').
 * @returns {Window|null} Referencia a la nueva ventana, o null si falla (ej: pop-up bloqueado).
 */
export function abrirVentana(url, params, features) {
    let fullUrl = url;

    if (params) {
        let queryString = "";
        if (typeof params === "string") {
            queryString = params;
        } else if (typeof params === "object") {
            // Construir query string desde objeto
            const queryParts = Object.keys(params)
                .map((key) => {
                    const value = params[key];
                    if (value === null || value === undefined) {
                        return ""; // Omitir parámetros con valor nulo/indefinido
                    }
                    return `${encodeURIComponent(key)}=${encodeURIComponent(
                        String(value)
                    )}`;
                })
                .filter((part) => part !== ""); // Eliminar partes vacías

            if (queryParts.length > 0) {
                queryString = "?" + queryParts.join("&");
            }
        }

        // Combinar URL base con la query string
        if (queryString) {
            fullUrl = `${url}${
                url.includes("?") ? "&" : "?"
            }${queryString.substring(1)}`;
        }
    }

    // console.log("Opening window with URL:", fullUrl, "and features:", features);
    const newWindow = window.open(fullUrl, "_blank", features);

    return newWindow; // Devolver la referencia a la ventana
}

/**
 * Populates form fields from URL parameters.
 * @param {HTMLElement|string} formTarget - The form element or its ID.
 * @param {string[]} formFields - An array of field names to check in URL parameters.
 * @param {boolean} [debug=false] - Optional flag to enable console logging for debugging.
 */
export function populateFormFromUrlParams(
    formTarget,
    formFields,
    debug = false
) {
    const formElement =
        typeof formTarget === "string"
            ? document.getElementById(formTarget)
            : formTarget;

    if (!formElement) {
        if (debug)
            console.warn(
                "[populateFormFromUrlParams] Form element not found:",
                formTarget
            );
        return;
    }

    const urlParams = new URLSearchParams(window.location.search);
    if (debug)
        console.log(
            "[populateFormFromUrlParams] Raw URL Search:",
            window.location.search
        );
    if (debug)
        console.log(
            "[populateFormFromUrlParams] Parsed URL Params:",
            urlParams.toString()
        );
    if (debug)
        console.log(
            "[populateFormFromUrlParams] Form Fields to check:",
            formFields
        );

    formFields.forEach((fieldName) => {
        if (urlParams.has(fieldName)) {
            const valueToSet = urlParams.get(fieldName);
            // Usamos jQuery para encontrar el elemento, similar a como lo hace BaseModule
            const fieldjQueryElement = $(formElement).find(
                `[name="${fieldName}"]`
            );
            const fieldNativeElement = fieldjQueryElement[0]; // Elemento DOM nativo para dispatchEvent

            if (fieldjQueryElement.length) {
                if (debug)
                    console.log(
                        `[populateFormFromUrlParams] Param FOUND: "${fieldName}". Setting field [name="${fieldName}"] with value:`,
                        valueToSet
                    );

                if (
                    fieldjQueryElement.is("select") &&
                    fieldjQueryElement.attr("data-table")
                ) {
                    // Componente select personalizado (form-select que usa data-table)
                    if (debug)
                        console.log(
                            `[populateFormFromUrlParams] Dispatching 'set-value' for custom select [name="${fieldName}"]`
                        );
                    if (fieldNativeElement) {
                        fieldNativeElement.dispatchEvent(
                            new CustomEvent("set-value", {
                                detail: { value: valueToSet },
                                bubbles: true,
                            })
                        );
                    }
                } else if (fieldjQueryElement.is(":checkbox")) {
                    // Manejo para checkboxes
                    const checkedValue = String(valueToSet).toUpperCase();
                    // Considera 'true', '1', 'A' (activo), 'ON' como valores para marcar el checkbox
                    fieldjQueryElement.prop(
                        "checked",
                        ["TRUE", "1", "A", "ON"].includes(checkedValue)
                    );
                    fieldjQueryElement.trigger("change"); // Disparar evento change
                } else if (fieldjQueryElement.is(":radio")) {
                    // Manejo para radio buttons
                    $(formElement)
                        .find(`[name="${fieldName}"][value="${valueToSet}"]`)
                        .prop("checked", true);
                    $(formElement)
                        .find(`[name="${fieldName}"]`)
                        .trigger("change"); // Disparar evento change en el grupo
                } else if (
                    fieldjQueryElement.attr("type") === "date" ||
                    fieldjQueryElement.attr("type") === "datetime-local"
                ) {
                    // Manejo para campos de fecha y fecha/hora
                    try {
                        if (valueToSet) {
                            // Intenta crear un objeto Date. El valor de la URL debe ser un formato que Date() pueda interpretar (ej. ISO)
                            const date = new Date(valueToSet);
                            let formattedValue = valueToSet; // Valor por defecto si la conversión falla

                            if (!isNaN(date.valueOf())) {
                                // Verifica si la fecha es válida
                                if (
                                    fieldjQueryElement.attr("type") === "date"
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
                            }
                            fieldjQueryElement.val(formattedValue);
                        } else {
                            fieldjQueryElement.val(""); // Limpiar si el valor es nulo/vacío
                        }
                    } catch (e) {
                        if (debug)
                            console.warn(
                                `[populateFormFromUrlParams] Could not format date for field [name="${fieldName}"]:`,
                                valueToSet,
                                e
                            );
                        fieldjQueryElement.val(valueToSet); // Usar valor original si falla el formato
                    }
                    fieldjQueryElement.trigger("input").trigger("change"); // Disparar eventos
                } else {
                    // Para inputs normales (text, number, hidden, textarea, etc.) y selects estándar
                    fieldjQueryElement.val(valueToSet);
                    fieldjQueryElement.trigger("input").trigger("change"); // Disparar eventos
                }
            } else {
                if (debug)
                    console.warn(
                        `[populateFormFromUrlParams] Field [name="${fieldName}"] not found in form.`
                    );
            }
        }
    });
}

/**
 * Formatea un valor numérico a una cadena de texto representando una moneda.
 * Utiliza el formato de número con dos decimales y separador de miles.
 * @author ASICOM
 * @license MIT
 * @version 1.0.0
 * @description Esta función convierte un número a una cadena de texto formateada como moneda.
 * @param {*} valor 
 * @returns 
 */
export function formatearMoneda(valor) {
    valor = parseFloat(valor);
    if (isNaN(valor)) return '';
    return valor.toLocaleString('es-MX', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

/** 
 * Desformatea una cadena de texto representando una moneda a un valor numérico.
 * Elimina los separadores de miles y convierte la cadena a un número flotante.
 * @author ASICOM 
 * @license MIT
 * @version 1.0.0
 * @description Esta función convierte una cadena de texto formateada como moneda a un número.
 * @param {string} valor 
 * @returns 
 */
export function desformatearMoneda(valor) {
    if (!valor) return 0;
    return parseFloat(valor.replace(/,/g, '')) || 0;
}

/**
 * Renderiza un valor monetario con el símbolo de moneda.
 * Utiliza el formato de número con dos decimales y separador de miles.
 * @author ASICOM
 * @param {*} data 
 * @param {*} type 
 * @param {*} row 
 * @returns 
 */
export function renderMoneda(data, type, row) {
    if (type === 'display') {
        return '$ ' + formatearMoneda(data);
    }
    return data; // Para otros tipos de renderizado, devuelve el valor original
}

/**
 * Renderiza un valor porcentual añadiendo el símbolo de porcentaje.
 * @author ASICOM
 * @param {*} data 
 * @param {*} type 
 * @param {*} row 
 * @returns 
 */
export function renderPorcentaje(data, type, row) {
    if (type === 'display') {
        return data + '%';
    }
    return data; // Para otros tipos de renderizado, devuelve el valor original
}

/**
 * Verifica los parámetros de la URL al cargar la página y simula un clic en un botón si los encuentra.
 * @param {object} config - Objeto de configuración del módulo actual con dataTableId.
 * @param {function} callback - Función que se ejecutará si se encuentran los parámetros.
 */
export function ejecutarAccionDesdeURL(config, callback) {
    const urlParams = new URLSearchParams(window.location.search);
    const openModal = urlParams.get('openModal');
    const mode = urlParams.get('modo');
    const id = urlParams.get('id');
    
    if (openModal === 'true' && mode && id) {
        // Ejecuta el callback solo si los parámetros existen
        callback(mode, id);
    }
}
import Swal from "sweetalert2";
import axios from "axios";
import { showMessage } from "./messageHelper";

/**
 * Maneja errores de una petición AJAX y muestra un mensaje con SweetAlert2.
 * También muestra los errores de validación en los campos del formulario.
 * @param {Object} error - Objeto de error de Axios.
 */
export function handleAjaxError(error) {
    console.error("Error en la petición:", error);

    if (error.response) {
        const { status, data } = error.response;

        // Si Laravel indica que los errores deben mostrarse en los inputs
        if (status === 422 && data.errors) {
            mostrarErrores(data.errors);
            return; // No mostrar SweetAlert2
        }

        let errorMessage = "Ocurrió un error inesperado.";

        if (data?.message) {
            errorMessage = data.message;
        } else if (status === 401) {
            errorMessage = "Sesión expirada o no autorizado.";
            localStorage.removeItem("token"); // Eliminar token vencido
            window.location.href = "/login"; // Redirigir al login
        } else if (status === 403) {
            errorMessage = "No tienes permisos para acceder a este recurso.";
        } else if (status === 500) {
            errorMessage = "Error interno del servidor.";
        } else if (error.request) {
            errorMessage = "No se recibió respuesta del servidor.";
        }

        // Mostrar SweetAlert si no es un error de input
        //Swal.fire("Error", errorMessage, "error");
        showMessage("error", "", errorMessage);
    }
}

/**
 * Muestra los errores en los campos del formulario.
 * @param {Object} errors - Objeto con los errores de validación.
 */
export function mostrarErrores(errors) {
    let firstErrorField = null;

    for (const campo in errors) {
        const inputField = document.getElementById(campo);
        if (inputField) {
            // Agregar clases de error
            inputField.classList.add("art-input-error", "focus:ring-red-500");

            // Mostrar el icono de error
            let errorIcon = inputField
                .closest("div")
                ?.querySelector(".error-icon");
            if (errorIcon) errorIcon.classList.remove("invisible");

            // Mostrar mensaje de error
            let errorMessage = document.getElementById(
                `hs-validation-${campo}-error-helper`
            );
            if (errorMessage) {
                errorMessage.textContent = errors[campo][0];
                errorMessage.classList.remove("invisible");
            }

            if (!firstErrorField) {
                firstErrorField = inputField;
            }
        }
    }

    if (firstErrorField) firstErrorField.focus();
}

/**
 * Limpia los errores previos antes de una nueva validación.
 */
export function limpiarErrores() {
    document.querySelectorAll("input").forEach((input) => {
        input.classList.remove("art-input-error", "focus:ring-red-500");
    });

    document
        .querySelectorAll(".error-icon")
        .forEach((icon) => icon.classList.add("invisible"));
    document.querySelectorAll(".error-message").forEach((msg) => {
        msg.classList.add("invisible");
        msg.textContent = "";
    });
}

/**
 * Realiza una petición AJAX con Axios.
 * @param {string} url - URL del endpoint.
 * @param {string} method - Método HTTP (GET, POST, PUT, DELETE).
 * @param {Object} data - Datos a enviar en el body.
 * @param {Function} successCallback - Función a ejecutar en caso de éxito.
 * @param {Function} errorCallback - Función a ejecutar en caso de error.
 * @param {Object} headers - Encabezados HTTP adicionales.
 */
export function sendAjaxRequest(
    url,
    method,
    data,
    successCallback,
    errorCallback,
    headers = {}
) {
    limpiarErrores(); // Limpiar errores antes de enviar

    const token = localStorage.getItem("token");

    let requestHeaders = {
        "Content-Type": "application/json",
        ...(token && { Authorization: `Bearer ${token}` }), // Agregar token si existe
        ...headers,
    };

    //// console.log("Enviando petición a:", url, "con headers:", requestHeaders);
    axios({
        url,
        method,
        data,
        headers: requestHeaders,
        //   withCredentials: true,
    })
        .then((response) => {
            // console.log("Respuesta exitosa:", response);
            if (response.status === 200) {
                successCallback(response.data);
            } else {
                console.warn("Respuesta inesperada:", response);
                handleAjaxError(response); // Opcional, si quieres manejar respuestas inesperadas
            }
        })
        .catch((error) => {
            console.error("Error en la petición:", error);
            handleAjaxError(error);
            if (errorCallback) errorCallback(error);
        });
}

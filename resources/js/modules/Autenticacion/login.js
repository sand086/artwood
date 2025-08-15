// resources/js/modules/Autenticacion/login.js

import {
    sendAjaxRequest,
    handleAjaxError,
    limpiarErrores,
    mostrarErrores,
} from "../../Helpers/ajaxHelper";

function esperarGrecaptchaYEjecutar(callback) {
    if (typeof grecaptcha !== "undefined") {
        grecaptcha.ready(callback);
    } else {
        setTimeout(() => esperarGrecaptchaYEjecutar(callback), 100);
    }
}

function obtenerSiteKey() {
    return document
        .querySelector('meta[name="recaptcha-key"]')
        .getAttribute("content");
}

// —————————————————————
// 1) Pre‐ejecutar v3 al cargar para que aparezca el badge
// —————————————————————
esperarGrecaptchaYEjecutar(() => {
    const siteKey = obtenerSiteKey();
    if (siteKey) {
        // esto inyecta el badge en la esquina
        grecaptcha.execute(siteKey, { action: "login" });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const loginForm = document.getElementById("loginForm");

    loginForm.addEventListener("submit", function (event) {
        event.preventDefault();
        limpiarErrores();

        // 2) Recopilamos datos del formulario
        const usuario = document.getElementById("usuario").value.trim();
        const contrasena = document.getElementById("contrasena").value.trim();
        const codigo2FA = document.getElementById("codigo_2fa").value.trim();

        if (!usuario || !contrasena) {
            mostrarErrores({
                usuario: usuario ? [] : ["El usuario es obligatorio."],
                contrasena: contrasena ? [] : ["La contraseña es obligatoria."],
            });
            return;
        }

        const requestData = { usuario, contrasena };
        if (codigo2FA) requestData.codigo_2fa = codigo2FA;

        // 3) Generar token v3 justo antes de enviar
        esperarGrecaptchaYEjecutar(() => {
            const siteKey = obtenerSiteKey();
            grecaptcha.execute(siteKey, { action: "login" }).then((token) => {
                requestData.recaptcha = token;

                // 4) Enviar petición de login
                sendAjaxRequest(
                    "/api/auth/login",
                    "POST",
                    requestData,
                    (response) => {
                        if (response.resultado) {
                            localStorage.setItem("token", response.token);
                            localStorage.setItem(
                                "roles",
                                JSON.stringify(response.roles)
                            );
                            localStorage.setItem(
                                "permisos",
                                JSON.stringify(response.permisos)
                            );

                            if (response.clave_2fa) {
                                localStorage.setItem(
                                    "clave_2fa",
                                    response.clave_2fa
                                );
                                localStorage.setItem(
                                    "clave_2fa_url",
                                    response.clave_2fa_url
                                );
                                window.location.href = "/registro-2fa";
                            } else {
                                window.location.href = "/home";
                            }
                        } else {
                            mostrarErrores(
                                response.errors || { error: [response.message] }
                            );
                        }
                    },
                    (error) => {
                        handleAjaxError(error);
                    }
                );
            });
        });
    });
});

import { showMessage } from "../../Helpers/messageHelper";
import { sendAjaxRequest, handleAjaxError } from "../../Helpers/ajaxHelper";

document.addEventListener("DOMContentLoaded", function () {
    const spinner = document.getElementById("spinner");
    const qrImage = document.getElementById("clave2AFQr");
    const clave2FAElement = document.getElementById("clave2AF");

    // Mostrar el spinner mientras se carga
    spinner.style.display = "inline-block";
    qrImage.style.display = "none";
    clave2FAElement.textContent = "Cargando...";

    setTimeout(() => {
        let clave2FA = localStorage.getItem("clave_2fa");
        let qrUrl = localStorage.getItem("clave_2fa_url");

        clave2FAElement.textContent = clave2FA || "No disponible";

        if (qrUrl) {
            qrImage.src = qrUrl;
            qrImage.style.display = "block";
        }

        // Ocultar spinner después de cargar los datos
        spinner.style.display = "none";
    }, 2000);

    // Capturar el evento del botón de verificación
    const verificarBtn = document.querySelector("#verificar_2af_registro");
    if (verificarBtn) {
        verificarBtn.addEventListener("click", function () {
            let codigo2FA = "";
            document
                .querySelectorAll("[data-hs-pin-input-item]")
                .forEach((input) => {
                    codigo2FA += input.value.trim();
                });

            if (codigo2FA.length !== 6 || isNaN(codigo2FA)) {
                showMessage(
                    "warning",
                    "Por favor ingresa un código válido de 6 dígitos."
                );
                return;
            }

            let token = localStorage.getItem("token");

            if (!token) {
                showMessage(
                    "error",
                    "Sesión expirada. Inicia sesión nuevamente.",
                    {
                        confirmText: "Ir al inicio",
                    }
                ).then(() => {
                    window.location.href = "/login";
                });
                return;
            }

            // Enviar solicitud AJAX a `/api/verificar-2fa`
            sendAjaxRequest(
                "/api/auth/verificar-2fa",
                "POST",
                { codigo_2fa: codigo2FA, error_input: 400 }, // Solo enviamos el código 2FA
                (response) => {
                    // console.log("Respuesta completa:", response);

                    // Verifica si response.data existe
                    let responseData = response.data || response; // Usa `response` si `data` es undefined
                    // console.log("Respuesta completa:", responseData);

                    if (responseData.resultado) {
                        showMessage(
                            "success",
                            "Autenticación exitosa. Redirigiendo...",
                            "",
                            { timer: 2000 }
                        ).then(() => {
                            window.location.href = "/home";
                        });
                    } else {
                        showMessage(
                            "error",
                            "Código 2FA inválido. Intenta nuevamente.",
                            responseData.message ||
                                "Código incorrecto. Intenta de nuevo."
                        );
                    }
                },
                (error) => {
                    handleAjaxError(error);
                }
            );
        });
    }
});

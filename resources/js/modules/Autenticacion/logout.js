import { showMessage } from "../../Helpers/messageHelper";
import { sendAjaxRequest, handleAjaxError } from "../../Helpers/ajaxHelper";

document.addEventListener("DOMContentLoaded", function () {
    const logoutButtons = document.querySelectorAll(".logoutButton");

    logoutButtons.forEach((logoutButton) => {
        logoutButton.addEventListener("click", function (event) {
            event.preventDefault(); // Evita la navegación predeterminada

            showMessage(
                "confirm",
                "¿Estás seguro de que deseas cerrar sesión?"
            ).then((result) => {
                if (result.isConfirmed) {
                    cerrarSesion();
                }
            });
        });
    });
});

/**
 * Función para cerrar sesión de manera segura.
 */
function cerrarSesion() {
    const token = localStorage.getItem("token");

    if (!token) {
        showMessage("error", "No hay sesión activa.");
        window.location.href = "/login"; // Redirigir si no hay sesión
        return;
    }

    sendAjaxRequest(
        "/api/auth/logout",
        "POST",
        {},
        (response) => {
            if (response.resultado) {
                // Eliminar token del localStorage
                localStorage.removeItem("token");

                // Eliminar la cookie del token (asegurando compatibilidad)
                document.cookie =
                    "token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC; SameSite=Lax";

                // Mostrar mensaje y redirigir
                showMessage("success", "Sesión cerrada correctamente").then(
                    () => {
                        window.location.href = "/login";
                    }
                );
            } else {
                showMessage(
                    "error",
                    response.message || "No se pudo cerrar sesión."
                );
            }
        },
        (error) => {
            handleAjaxError(error);
        }
    );
}

// resources/js/Helpers/verificarAutenticacion.js

import {
    obtenerToken,
    getUserProfile,
    refrescarToken,
    redirigirLogin,
} from "./auth";

(function () {
    const token = obtenerToken();
    const enLogin = window.location.pathname.includes("/login");

    // 1) Si NO hay token:
    if (!token) {
        if (!enLogin) {
            // → ruta privada sin token: redirige al login
            redirigirLogin();
        } else {
            // → estamos en /login sin token: mostramos la UI
            document.documentElement.style.visibility = "visible";
        }
        return;
    }

    // 2) Si HAY token: validamos el token
    fetch("/api/auth/validar-token", { method: "GET" })
        .then((res) => {
            if (!res.ok) {
                console.warn("Token inválido, intentando refrescar…");
                // Intentamos refrescar el token
                return refrescarToken().then((usuario) => {
                    if (!usuario) {
                        // No se pudo refrescar → forzamos login
                        throw new Error("No se pudo refrescar el token");
                    }
                });
            }
        })
        .then(() => {
            // 3) Token válido o renovado → cargamos perfil de usuario
            const { nombre, foto_url } = getUserProfile(token);
            document.documentElement.dataset.usuario = nombre || "";
            document.documentElement.dataset.foto = foto_url || "";
            // 4) Finalmente, mostramos la UI
            document.documentElement.style.visibility = "visible";
        })
        .catch(() => {
            // Error validando o refrescando → redirige al login
            redirigirLogin();
        });
})();

// auth.js
// Utilidades para manejar JWT, token storage y autenticación

/**
 * Decodifica el payload de un JWT sin validar firma.
 * @param {string} token - el JWT completo (header.payload.signature)
 * @returns {object} payload decodificado
 */
export function parseJwt(token) {
    const base64Url = token.split(".")[1] || "";
    const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
    const jsonPayload = decodeURIComponent(
        atob(base64)
            .split("")
            .map((c) => "%" + c.charCodeAt(0).toString(16).padStart(2, "0"))
            .join("")
    );
    return JSON.parse(jsonPayload);
}

/**
 * Extrae nombre y foto_url desde el payload del JWT
 * @param {string} token
 * @returns {{nombre: string, foto_url: string|null}}
 */
export function getUserProfile(token) {
    const { nombre, foto_url } = parseJwt(token);
    return { nombre, foto_url };
}

/**
 * Obtiene el token desde localStorage o cookies según el dominio
 * @returns {string|null}
 */
export function obtenerToken() {
    const host = window.location.hostname;
    if (
        host === "artwoodapp.com" ||
        host === "127.0.0.1" ||
        host === "localhost"
    ) {
        return localStorage.getItem("token");
    }
    // obtiene de cookies
    const match = document.cookie
        .split("; ")
        .find((row) => row.startsWith("token="));
    return match ? match.split("=")[1] : null;
}

/**
 * Guarda el token en localStorage o cookies según el dominio
 * @param {string} token
 */
export function guardarToken(token) {
    const host = window.location.hostname;
    if (
        host === "artwoodapp.com" ||
        host === "127.0.0.1" ||
        host === "localhost"
    ) {
        localStorage.setItem("token", token);
        document.cookie = `token=${token}; path=/; SameSite=Lax;${
            location.hostname === "localhost" ? "" : " Secure"
        }`;
    }
}

/**
 * Elimina el token de storage
 */
export function eliminarToken() {
    const host = window.location.hostname;
    if (
        host === "artwoodapp.com" ||
        host === "127.0.0.1" ||
        host === "localhost"
    ) {
        localStorage.removeItem("token");
    } else {
        document.cookie =
            "token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC; SameSite=Lax";
    }
}

/**
 * Intenta refrescar el token cuando expira
 * @returns {Promise<object|null>} usuario o null si falla
 */
// auth.js

export async function refrescarToken() {
    try {
        const token = obtenerToken();
        const res = await fetch("/api/auth/refresh", {
            method: "POST",
            headers: {
                Authorization: `Bearer ${token || ""}`,
                "Content-Type": "application/json",
            },
            credentials: "include",
        });

        const data = await res.json();
        if (!res.ok || !data.usuario) {
            // si falló, borramos y redirigimos
            cerrarSesion();
            return null;
        }
        // guardamos el nuevo token
        guardarToken(data.token);
        return data.usuario;
    } catch (e) {
        cerrarSesion();
        return null;
    }
}

/**
 * Fuerza el logout: borra token y redirige a login
 */
export function cerrarSesion() {
    eliminarToken();
    window.location.href = "/login";
}

/**
 * Redirige a la página de login
 */
export function redirigirLogin() {
    if (!window.location.pathname.includes("/login")) {
        window.location.href = "/login";
    }
}

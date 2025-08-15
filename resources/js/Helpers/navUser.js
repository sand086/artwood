// navUser.js
// Componente Alpine para manejar nombre y foto del usuario en la navbar

import { obtenerToken, getUserProfile } from "./auth";

export default function navUser() {
    return {
        open: false,
        nombre: "",
        foto_url: "",
        rol: "",
        init() {
            // Obtener datos desde el token
            const token = obtenerToken();
            if (token) {
                const { nombre, foto_url } = getUserProfile(token);
                this.nombre = nombre;
                this.foto_url = foto_url;
            }
            // Obtener rol(es) desde localStorage
            const rolesData = localStorage.getItem("roles");
            if (rolesData) {
                try {
                    const rolesArray = JSON.parse(rolesData);
                    this.rol = Array.isArray(rolesArray)
                        ? rolesArray.join(", ")
                        : String(rolesArray);
                } catch (e) {
                    this.rol = rolesData;
                }
            }
        },
    };
}

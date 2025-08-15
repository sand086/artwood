// resources/js/app.js

// -----------------------------
// 1) Override global de fetch para inyectar Bearer token y refresco automático
// -----------------------------
import { obtenerToken, refrescarToken, redirigirLogin } from "./Helpers/auth";

// … al principio de app.js …

const _fetch = window.fetch;
window.fetch = async (input, init = {}) => {
    // 1) Determina la URL
    const url = typeof input === "string" ? input : input.url;

    // 2) Si es refresh, no lo interceptes
    if (url.endsWith("/api/auth/refresh")) {
        return _fetch(input, init);
    }

    // 3) Inyecta el token en todas las demás
    init.headers = {
        ...(init.headers || {}),
        Authorization: `Bearer ${obtenerToken() || ""}`,
        "Content-Type": "application/json",
    };
    init.credentials = "include";

    let response = await _fetch(input, init);

    // 4) Solo si NO es refresh y recibes 401, refresca
    if (response.status === 401) {
        const usuario = await refrescarToken();
        if (usuario) {
            init.headers.Authorization = `Bearer ${obtenerToken()}`;
            response = await _fetch(input, init);
        } else {
            redirigirLogin();
        }
    }

    return response;
};

// -----------------------------
// 2) Indicador de progreso con NProgress
// -----------------------------
import NProgress from "nprogress";
import "nprogress/nprogress.css";

window.addEventListener("beforeunload", () => {
    NProgress.start();
});
window.addEventListener("load", () => {
    NProgress.done();
});

// -----------------------------
// 3) Importación de librerías globales
// -----------------------------
import $ from "jquery";
window.$ = window.jQuery = $;

import axios from "axios";
window.axios = axios;

import JSZip from "jszip";
window.JSZip = JSZip;

import pdfMake from "pdfmake/build/pdfmake";
import { vfs } from "pdfmake/build/vfs_fonts";
pdfMake.vfs = vfs;
window.pdfMake = pdfMake;

import _ from "lodash";
window._ = _;

import Dropzone from "dropzone";
window.Dropzone = Dropzone;

// -----------------------------
// 4) Estilos y librerías de UI
// -----------------------------
import "../css/app.css";

import Swal from "sweetalert2";
window.Swal = Swal;

// -----------------------------
// 5) DataTables y extensiones
// -----------------------------
import "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print";
import "datatables.net-buttons/js/buttons.colVis";
import "datatables.net-responsive";

// -----------------------------
// 6) Lucide Icons
// -----------------------------
import { createIcons, icons } from "lucide";
document.addEventListener("DOMContentLoaded", () => {
    createIcons({ icons });
});

// -----------------------------
// 7) Componentes de UI personalizados
// -----------------------------
// BaseModule para módulos de DataTable u otros
// -----------------------------
import BaseModule from "./modules/BaseModule";
window.BaseModule = BaseModule;
import "./components/form-select-handler.js";
import { initPopupFormHandler } from './Helpers/popup-form-handler.js';

// -----------------------------
// 8) Carga dinámica de módulos
// -----------------------------
const modules = import.meta.glob("./modules/**/index.js");

document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector("[data-module]");
    const moduleName = container?.getAttribute("data-module");
    if (!moduleName) return;

    const matchingKey = Object.keys(modules).find((key) =>
        key.toLowerCase().includes(`/${moduleName.toLowerCase()}/`)
    );
    if (matchingKey) {
        modules[matchingKey]()
            .then((module) => {
                if (typeof module.init === "function") {
                    module.init();
                }
            })
            .catch((error) => {
                console.error("Error al cargar el módulo:", moduleName, error);
            });
    } else {
        console.warn(
            `No se encontró ningún módulo que coincida con: ${moduleName}`
        );
    }
    // Inicializar el manejador de formularios emergentes
    initPopupFormHandler();
});

// -----------------------------
// 9) Configuración global para AJAX: CSRF
// -----------------------------
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

// -----------------------------
// 10) Configuración de tema (oscuro/claro)
// -----------------------------
document.addEventListener("DOMContentLoaded", () => {
    const savedTheme = localStorage.getItem("theme") || "light";
    document.documentElement.classList.toggle("dark", savedTheme === "dark");

    document.querySelectorAll("[data-hs-theme-click-value]").forEach((btn) => {
        btn.addEventListener("click", (e) => {
            const theme = e.currentTarget.getAttribute(
                "data-hs-theme-click-value"
            );
            localStorage.setItem("theme", theme);
            document.documentElement.classList.toggle("dark", theme === "dark");
        });
    });
});

// -----------------------------
// 11) Inicialización de Alpine.js y componentes
// -----------------------------
import Alpine from "alpinejs";
window.Alpine = Alpine;

document.addEventListener("alpine:init", () => {
    Alpine.data("layout", () => ({
        sidebarOpen: true,
        cotizacionesOpen: false,
        configuracionOpen: false,
        sistemaOpen: false,
    }));
});

// -----------------------------
// 12) Verificación de autenticación al cargar
// -----------------------------
import "./Helpers/verificarAutenticacion";

// -----------------------------
// 13) NavUser y otros Helpers
// -----------------------------
import navUser from "./Helpers/navUser";
window.navUser = navUser;

// -----------------------------
// 14) Módulos adicionales de autenticación y permisos
// -----------------------------
import "./modules/Autenticacion/logout";
import "./Helpers/verificarPermisos";

// -----------------------------
// 15) Arranca Alpine
// -----------------------------
Alpine.start();

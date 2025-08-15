import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import { resolve } from "path";

export default defineConfig(({ mode }) =>{
    const env = loadEnv(mode, process.cwd(), ""); // El tercer argumento '' carga todas las variables sin prefijo
    
    return {
        base: env.VITE_BASE, // Cambia la base según tu entorno
        plugins: [
            laravel({
                input: [
                    "resources/css/app.css",
                    "resources/js/app.js",
                    "resources/js/Helpers/verificarAutenticacion.js",
                    "resources/js/modules/Autenticacion/index.js",
                    "resources/js/modules/Autenticacion/registro2AF.js",
                    "resources/js/modules/Autenticacion/login.js",
                ],
                refresh: true,
                // root: 'resources',
            }),
        ],
        build: {
            // manifest: true, // manifest.json
            // outDir: resolve(__dirname, 'public/build'),
            rollupOptions: {
                output: {
                    manualChunks(id) {
                        if (id.includes("node_modules")) {
                            const packageName = id
                                .toString()
                                .split("node_modules/")[1]
                                .split("/")[0];
                            if (packageName === "preline") {
                                return "ignore-preline"; //  Preline no se incluye en el bundle
                            }
                            return packageName;
                        }
                    },
                },
            },
            chunkSizeWarningLimit: 1000, // Evitar advertencias de tamaño
        },
        optimizeDeps: {
            include: [
                "jquery",
                "bootstrap",
                "sweetalert2",
                "datatables.net",
                "datatables.net-buttons",
                "datatables.net-buttons/js/buttons.html5",
                "datatables.net-buttons/js/buttons.print",
                "datatables.net-responsive",
                "alpinejs",
                "lucide",
            ],
            exclude: ["preline"], // Excluir Preline de la compilación de Vite
        },
    };
});

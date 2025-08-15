import defaultTheme from "tailwindcss/defaultTheme";
import plugin from "tailwindcss/plugin";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "class", // Modo oscuro activado por clase
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "node_modules/preline/dist/*.js",
    ],
    safelist: [
        "bg-primary",
        "bg-primary-dark",
        "art-btn-primary",
        "art-btn-secondary",
        "peer-checked:bg-primary",
        "translate-x-5",
        "peer-focus:ring-2",
        "peer-focus:ring-primary",
        "opacity-50",
        "cursor-not-allowed",
        "art-select-custom",
    ],
    theme: {
        extend: {
            colors: {
                primary: { DEFAULT: "#263A4E", dark: "#1f2c3a" }, // Azul principal
                secondary: { DEFAULT: "#C0CB08" }, // Verde claro secundario
                tertiary: { DEFAULT: "#E5E4E4" }, // Gris terciario
                accent: { DEFAULT: "#4D7940" }, // Verde oscuro como acento
                background: { DEFAULT: "#FAFBFB" }, // Fondo muy claro
                danger: { DEFAULT: "#DC2626" },
                warning: { DEFAULT: "#FBBF24" },
                success: { DEFAULT: "#4ADE80" },
                info: { DEFAULT: "#3B82F6" },
                muted: { DEFAULT: "#6B7280" },
                light: { DEFAULT: "#F3F4F6" },
                dark: { DEFAULT: "#111827" },
            },
            fontFamily: {
                sans: ['"Source Sans Pro"', ...defaultTheme.fontFamily.sans],
                poppins: ['"Poppins"', "sans-serif"],
            },
        },
    },
    plugins: [
        require("preline/plugin"),
        plugin(function ({ addUtilities, theme }) {
            const colors = theme("colors");
            const newUtilities = {};
            const prefijo = "art";

            // Utilidades para texto, fondos y botones
            Object.keys(colors).forEach((key) => {
                if (typeof colors[key] === "object" && colors[key].DEFAULT) {
                    newUtilities[`.${prefijo}-text-${key}`] = {
                        color: colors[key].DEFAULT,
                    };
                    newUtilities[`.${prefijo}-bg-${key}`] = {
                        backgroundColor: colors[key].DEFAULT,
                    };
                    newUtilities[`.${prefijo}-btn-${key}`] = {
                        backgroundColor: colors[key].DEFAULT,
                        color: key === "primary" ? "#fff" : "#000",
                        padding: "0.75rem 1.5rem",
                        borderRadius: "0.375rem",
                        fontWeight: "600",
                        transition: "all 0.3s ease",
                        "&:hover": {
                            filter: "brightness(90%)",
                        },
                    };

                    newUtilities[`.${prefijo}-btn-outline-${key}`] = {
                        backgroundColor: "transparent",
                        color: colors[key].DEFAULT,
                        padding: "0.75rem 1.5rem",
                        borderRadius: "0.375rem",
                        fontWeight: "600",
                        border: `2px solid ${colors[key].DEFAULT}`,
                        transition: "all 0.3s ease",
                        "&:hover": {
                            backgroundColor: colors[key].DEFAULT,
                            color: key === "primary" ? "#fff" : "#000",
                            filter: "brightness(90%)",
                        },
                    };

                    // Utilidades para border y ring
                    newUtilities[`.${prefijo}-border-${key}`] = {
                        border: `1px solid ${colors[key].DEFAULT}`,
                    };
                    newUtilities[`.${prefijo}-ring-${key}`] = {
                        boxShadow: `0 0 0 3px ${colors[key].DEFAULT}`,
                    };
                }
            });

            // Utilidades para inputs
            newUtilities[`.${prefijo}-input`] = {
                borderRadius: "0.375rem",
                border: "1px solid #263A4E",
                fontSize: "1rem",
                outline: "none",
                transition: "all 0.2s ease-in-out",
                "&:focus": {
                    border: `solid 1px ${colors.primary.DEFAULT}`,
                    boxShadow: "0 0 0 2px rgba(38, 58, 78, 0.2)",
                },
            };

            newUtilities[`.${prefijo}-input-select`] = {
                borderRadius: "0.375rem",
                border: "1px solid #263A4E",
                fontSize: "1rem",
                outline: "none",
                transition: "all 0.2s ease-in-out",
                "&:focus": {
                    border: `solid 1px ${colors.primary.DEFAULT}`,
                    boxShadow: "0 0 0 2px rgba(38, 58, 78, 0.2)",
                },
            };

            newUtilities[`.${prefijo}-input-error`] = {
                border: "solid 1px #DC2626",
                "&:focus": {
                    boxShadow: "0 0 0 2px rgba(220, 38, 38, 0.2)",
                },
            };

            // Utilidad para tarjetas (cards)
            newUtilities[`.${prefijo}-card`] = {
                backgroundColor: theme("colors.white", "#fff"),
                borderRadius: "0.5rem",
                boxShadow: "0 4px 6px rgba(0, 0, 0, 0.1)",
                padding: "1rem",
            };

            addUtilities(newUtilities, ["responsive", "hover"]);
        }),
    ],
};

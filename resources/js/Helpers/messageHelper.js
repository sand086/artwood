import Swal from "sweetalert2";

/**
 * Muestra un mensaje personalizado con SweetAlert2 y estilos de Tailwind.
 *
 * @param {string} type - Tipo de mensaje: 'success', 'error', 'warning', 'info', 'confirm'.
 * @param {string} title - Título del mensaje.
 * @param {string} text - Texto descriptivo del mensaje.
 * @param {Object} options - Opciones adicionales (botones personalizados, temporizador, etc.).
 */
export function showMessage(type, title, text = "", options = {}) {
    const icons = {
        success: "success",
        error: "error",
        warning: "warning",
        info: "info",
        confirm: "question",
        continuar: "continuar",
    };

    // Estilos personalizados de SweetAlert2 basados en Tailwind
    const swalClasses = {
        popup: "rounded-xl shadow-lg p-6 art-bg-background",
        title: "font-poppins text-lg font-semibold art-text-primary",
        content: "font-sans text-sm text-gray-700",
        confirmButton:
            "art-btn-primary py-2 px-4 rounded-md shadow-md transition-all",
        cancelButton:
            "art-btn-tertiary py-2 px-4 rounded-md shadow-md transition-all",
    };

    // Opciones con valores por defecto
    const {
        confirmText = "Aceptar",
        cancelText = "Cancelar",
        timer = ["success", "info"].includes(type) ? 2500 : null,
        useAnimatedIcon = true, // Activar icono animado
        showConfirmButton = type !== "info",
        showCancelButton = type === "confirm",
        customClass = {}, // Clases personalizadas
        html = null, // Contenido HTML opcional
        ...restOptions
    } = options;

    // Si se activa `useAnimatedIcon`, usa la imagen animada en lugar del icono estándar de SweetAlert2
    const imageUrl = useAnimatedIcon
        ? `/images/icons/swal_alert/${
              type.charAt(0).toUpperCase() + type.slice(1)
          }.gif`
        : null;

    return Swal.fire({
        icon: imageUrl ? undefined : icons[type] || "info", // Si hay imagen, no usa icono predeterminado
        title,
        text,
        html, // Permite contenido HTML si se pasa en opciones
        showConfirmButton,
        showCancelButton,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        timer,
        imageUrl, // Imagen animada si `useAnimatedIcon` es true
        imageWidth: 80,
        imageHeight: 80,
        customClass: { ...swalClasses, ...customClass }, // Estilos personalizados
        ...restOptions, // Otras opciones de personalización
    });
}

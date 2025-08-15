window.Helpers = {
    /**
     * Muestra el modal dado su ID.
     * @param {string} modalId - ID del modal.
     */
    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.warn(`Modal con ID "${modalId}" no encontrado.`);
            return;
        }
        modal.classList.remove("hidden");
        modal.classList.add("open", "opened");
    },

    /**
     * Oculta el modal dado su ID.
     * @param {string} modalId - ID del modal.
     */
    hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.warn(`Modal con ID "${modalId}" no encontrado.`);
            return;
        }
        modal.classList.remove("open", "opened");
        modal.classList.add("hidden");
    },

    /**
     * Alterna la visibilidad del modal.
     * @param {string} modalId - ID del modal.
     */
    toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.warn(`Modal con ID "${modalId}" no encontrado.`);
            return;
        }
        modal.classList.toggle("hidden");
        modal.classList.toggle("open");
    },
};

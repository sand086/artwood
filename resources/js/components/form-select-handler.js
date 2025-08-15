'use strict';

import axios from 'axios';

/**
 * Clase FormSelect
 * Gestiona la lógica de un elemento <select> dinámico y dependiente.
 * Se inicializa automáticamente en los selects que tengan el atributo `data-table`.
 */
class FormSelect {
    /**
     * @param {HTMLSelectElement} element El elemento <select> del DOM.
     */
    constructor(element) {
        if (!element || element.dataset.formSelectInitialized) {
            return;
        }
        this.el = element;
        this.el.dataset.formSelectInitialized = 'true';

        this.config = this._parseConfig();
        this.state = {
            isVisible: false,
            isLoading: false,
            targetValue: this.config.initialValue || null,
            lastParentInfo: null,
        };

        this.parentSelects = this.config.parentIds.map(id => document.getElementById(id)).filter(Boolean);

        this._bindEvents();
        this._initialize();
    }

    /**
     * Parsea los atributos data-* del elemento para construir la configuración.
     * @returns {object} Objeto de configuración.
     */
    _parseConfig() {
        let parentIds = [];
        const parentIdInput = this.el.dataset.parentIdField || null;
        if (parentIdInput) {
            try {
                // Intenta parsear como JSON, que es el formato esperado para múltiples padres.
                const parsed = JSON.parse(parentIdInput);
                parentIds = Array.isArray(parsed) ? parsed.filter(id => typeof id === 'string' && id.trim()) : [];
            } catch (e) {
                // Si falla el parseo, lo trata como un único ID de padre.
                if (parentIdInput.trim()) {
                    parentIds = [parentIdInput.trim()];
                }
            }
        }

        return {
            id: this.el.id,
            table: this.el.dataset.table,
            valueField: this.el.dataset.valueField,
            labelField: this.el.dataset.labelField,
            placeholder: this.el.dataset.placeholder,
            populateFields: JSON.parse(this.el.dataset.populateFields || '[]'),
            where: JSON.parse(this.el.dataset.where || '{}'),
            orderBy: JSON.parse(this.el.dataset.orderBy || '[]'),
            parentIds: parentIds,
            initialValue: this.el.dataset.initialValue || null,
        };
    }

    /**
     * Vincula todos los eventos necesarios para el componente.
     */
    _bindEvents() {
        // Eventos del propio select
        this.el.addEventListener('change', this._handleChange.bind(this));
        this.el.addEventListener('invalid', () => this.el.classList.add('border-red-500'));

        // Eventos personalizados para control externo
        this.el.addEventListener('set-value', this._handleSetValue.bind(this));
        this.el.addEventListener('reload-options', () => this._update(true)); // Forzar recarga

        // Eventos de los selects padres
        this.parentSelects.forEach(pSelect => {
            pSelect.addEventListener('change', () => {
                this._update(true); // Solo recargar. El targetValue se preservará si fue establecido por 'set-value'.
            });
        });
    }

    /**
     * Inicializa el IntersectionObserver y realiza la primera actualización.
     */
    _initialize() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.target === this.el) {
                    const isNowVisible = entry.isIntersecting;
                    if (isNowVisible && !this.state.isVisible) {
                        this.state.isVisible = true;
                        this._update(); // Intentar actualizar al volverse visible
                    }
                    this.state.isVisible = isNowVisible;
                }
            });
        }, { root: null, threshold: 0.1 });

        observer.observe(this.el);
        // Si el elemento ya es visible al cargar la página, el observer lo detectará.
    }

    /**
     * Orquesta la actualización del select: carga de opciones y selección de valor.
     * @param {boolean} forceReload - Si es true, fuerza la recarga de opciones ignorando el caché.
     */
    async _update(forceReload = false) {
        if (this.state.isLoading) return;
        this.state.isLoading = true;
        this.el.disabled = true;

        const parentConditions = this._getParentConditions();
        if (parentConditions === null) { // Si un padre requerido está vacío
            this._clearOptions();
            this.state.isLoading = false;
            this.el.disabled = false;
            return;
        }

        const currentParentInfo = JSON.stringify(parentConditions);
        const needsLoad = forceReload || this.state.lastParentInfo !== currentParentInfo;

        if (needsLoad) {
            const success = await this._loadOptions(parentConditions);
            if (success) {
                this.state.lastParentInfo = currentParentInfo;
            } else {
                this.state.isLoading = false;
                this.el.disabled = false;
                return; // Detener si la carga falla
            }
        }

        this._selectTargetValue();

        this.state.isLoading = false;
        this.el.disabled = false;
    }

    /**
     * Carga las opciones desde la API.
     * @param {object} parentConditions - Condiciones de los padres para filtrar la consulta.
     * @returns {Promise<boolean>} - True si la carga fue exitosa, false si no.
     */
    async _loadOptions(parentConditions) {
        const params = {
            valueField: this.config.valueField,
            labelField: this.config.labelField,
            populateSourceKeys: this.config.populateFields.map(m => m.source_key),
            where: this.config.where,
            parentConditions: parentConditions || {},
        };
        if (this.config.orderBy.length === 2) {
            params.orderByColumn = this.config.orderBy[0];
            params.orderByDirection = this.config.orderBy[1];
        }

        try {
            const response = await axios.get(`/api/options/${this.config.table}`, { params });
            this._clearOptions(false); // Limpiar sin disparar 'change'

            response.data.forEach(optionData => {
                const option = document.createElement('option');
                option.value = optionData[this.config.valueField];
                option.textContent = optionData[this.config.labelField];
                // Añadir datos extra para la función de poblar otros campos
                Object.keys(optionData).forEach(key => {
                    if (key !== this.config.valueField && key !== this.config.labelField) {
                        option.dataset[key] = optionData[key];
                    }
                });
                this.el.appendChild(option);
            });

            this.el.dispatchEvent(new CustomEvent('options-loaded', { bubbles: true }));
            return true;
        } catch (error) {
            console.error(`Error loading options for #${this.config.id}:`, error);
            this._clearOptions(false);
            const errorOption = document.createElement('option');
            errorOption.value = "";
            errorOption.textContent = "Error al cargar";
            this.el.appendChild(errorOption);
            return false;
        }
    }

    /**
     * Obtiene las condiciones de los padres.
     * @returns {object|null} - Objeto con las condiciones o null si un padre requerido está vacío.
     */
    _getParentConditions() {
        if (this.parentSelects.length === 0) {
            return {}; // No hay padres, devuelve objeto vacío para proceder con la carga.
        }

        const conditions = {};
        for (const pSelect of this.parentSelects) {
            if (!pSelect.value) {
                return null; // Un padre no tiene valor, no se puede cargar.
            }
            // Usar el 'name' del padre como clave, que debe corresponder a la columna FK.
            conditions[pSelect.name || pSelect.id] = pSelect.value;
        }
        return conditions;
    }

    /**
     * Limpia las opciones del select.
     * @param {boolean} triggerChange - Si es true, dispara un evento 'change'.
     */
    _clearOptions(triggerChange = true) {
        const oldValue = this.el.value;
        this.el.innerHTML = '';
        if (this.config.placeholder) {
            this.el.innerHTML = `<option value="">${this.config.placeholder}</option>`;
        }
        this.el.value = '';
        this.state.lastParentInfo = null; // Resetea el caché de info de padres

        if (triggerChange && oldValue !== '') {
            this.el.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    /**
     * Selecciona el valor objetivo si existe.
     */
    _selectTargetValue() {
        if (this.state.targetValue !== null && this.state.targetValue !== '') {
            let found = false;
            for (const option of this.el.options) {
                if (String(option.value) === String(this.state.targetValue)) {
                    this.el.value = option.value;
                    found = true;
                    break;
                }
            }

            if (!found) {
                console.warn(`[${this.config.id}] Valor objetivo '${this.state.targetValue}' no encontrado.`);
                this.el.value = "";
            }
            // Una vez que el valor se ha seleccionado con éxito, se resetea.
            this.state.targetValue = null;
            this.el.dispatchEvent(new Event('change', { bubbles: true }));
        }
    }

    /**
     * Pobla campos mapeados basados en la selección actual.
     */
    _populateMappedFields() {
        if (!this.config.populateFields.length || !this.el.value) return;

        const selectedOption = this.el.options[this.el.selectedIndex];

        this.config.populateFields.forEach(mapping => {
            const targetEl = document.getElementById(mapping.target_id);
            if (!targetEl) {
                console.warn(`[${this.config.id}] Elemento objetivo #${mapping.target_id} no encontrado.`);
                return;
            }

            const sourceValue = selectedOption.dataset[mapping.source_key] || '';
            const isTargetFormSelect = targetEl.dataset.table;

            if (isTargetFormSelect) {
                targetEl.dispatchEvent(new CustomEvent('set-value', { detail: { value: sourceValue } }));
            } else {
                if (targetEl.value !== sourceValue) {
                    targetEl.value = sourceValue;
                    targetEl.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        });
    }

    /**
     * Manejador para el evento 'change' del select.
     */
    _handleChange() {
        if (this.el.validity.valid) {
            this.el.classList.remove('border-red-500');
        }
        this._populateMappedFields();
    }

    /**
     * Manejador para el evento personalizado 'set-value'.
     * @param {CustomEvent} event
     */
    _handleSetValue(event) {
        const value = event.detail.value;
        this.state.targetValue = (value !== null && value !== undefined) ? String(value) : null;

        // Dispara una actualización. _update() decidirá si necesita recargar las opciones
        // (si los padres cambiaron) o si solo intenta seleccionar el valor.
        this._update();
    }
}

/**
 * Lógica de inicialización para todos los form-selects en la página.
 */
document.addEventListener('DOMContentLoaded', function () {
    const selector = 'select[data-table][data-value-field][data-label-field]:not([data-form-select-initialized="true"])';

    // Función para inicializar un select
    const initSelect = (element) => new FormSelect(element);

    // Inicializar los selects que ya existen en el DOM
    document.querySelectorAll(selector).forEach(initSelect);

    // Usar MutationObserver para inicializar selects que se añaden dinámicamente
    const observer = new MutationObserver(mutationsList => {
        for (const mutation of mutationsList) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === Node.ELEMENT_NODE) {
                        // Si el nodo añadido es un select que coincide
                        if (node.matches(selector)) {
                            initSelect(node);
                        }
                        // Buscar selects que coincidan dentro del nodo añadido
                        node.querySelectorAll(selector).forEach(initSelect);
                    }
                });
            }
        }
    });

    // Observar cambios en el body y sus descendientes
    observer.observe(document.body, { childList: true, subtree: true });
});
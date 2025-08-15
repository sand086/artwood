import '../ProveedoresContactos/index.js';
import '../ProveedoresServicios/index.js';
import '../ProveedoresProductos/index.js';
import '../ProveedoresMateriales/index.js';
import '../ProveedoresEquipos/index.js';

import { abrirVentana } from '../../Helpers/utils.js';
window.abrirVentana = abrirVentana;

const config = {
    moduleName: 'Proveedores',
    baseUrl: '/proveedores/',
    idField: 'proveedor_id',
    formFields: ['nombre', 'tipo', 'rfc', 'direccion', 'codigo_postal', 'colonia', 'municipio_id', 'estado_pais_id', 
                'telefono', 'sitio_web', 'notas_adicionales', 'usuario_id'],
    moduleForm: 'proveedoresForm',
    moduleTable: 'proveedoresTable',
    moduleModal: 'proveedoresModal',
    closeModalOnSave: false,
    resetFormOnSave: false,
    targetTab: 'basicos',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'tipo', name: 'tipo', title: 'Tipo' },
        { data: 'direccion', name: 'direccion', title: 'Direccion' },
        { data: 'colonia', name: 'colonia', title: 'Colonia' },
        { data: 'municipio_nombre', name: 'municipio_nombre', title: 'Municipio' },
        { data: 'estado_pais_nombre', name: 'estado_pais_nombre', title: 'Estado Pais' },
        { data: 'telefono', name: 'telefono', title: 'Telefono' },
        // { data: 'usuario_id', name: 'usuario_id', title: 'Usuario' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
};

const proveedoresModule = new BaseModule(config);
proveedoresModule.init();

window.addEventListener('message', (event) => {
    if (event.origin === window.location.origin && event.data.action === 'materialCreado') {
        const material = event.data.registro;
        console.log('Producto creado recibido:', material);

        const selectElement = document.getElementById('material_id');
        if (selectElement) {
            selectElement.addEventListener('options-loaded', () => {
                // Ahora sabemos que las opciones están cargadas
                // Disparar el evento set-value para establecer el valor
                selectElement.dispatchEvent(new CustomEvent('set-value', {
                    detail: { value: material.material_id },
                    bubbles: true
                }));
                // Opcional: Enfocar el select
                selectElement.focus();
            }, { once: true }); // Escuchar solo una vez

            selectElement.dispatchEvent(new Event('reload-options'));
        }
    }
});
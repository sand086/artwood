import { render } from 'nprogress';
import { renderMoneda } from '../../Helpers/utils.js'; 

const agregarIconPS = "/images/icons/crud/iconos_agregar.svg";
const configPS = {
    moduleName: 'ProveedoresServicios',
    baseUrl: '/proveedoresservicios/',
    idField: 'proveedor_servicio_id',
    formFields: ['proveedor_id', 'servicio_id', 'descripcion', 'tiempo', 'unidad_medida_id', 'precio_unitario', 'detalle'],
    moduleForm: 'proveedoresserviciosForm',
    moduleTable: 'proveedoresserviciosTable',
    moduleModal: 'proveedoresModal', // 'proveedoresserviciosModal',
    parentIdField: 'proveedor_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'servicios', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-servicio',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-servicio',
    columns: [
        // { data: 'proveedor_id', name: 'proveedor_id', title: 'Proveedor', visible: false },
        { data: 'servicio_nombre', name: 'servicio_nombre', title: 'Servicio' },
        { data: 'tiempo', name: 'tiempo', title: 'Tiempo' },
        { data: 'unidad_medida_nombre', name: 'unidad_medida_nombre', title: 'Unidad Medida' },
        { data: 'precio_unitario', name: 'precio_unitario', title: 'Costo Unitario', render: renderMoneda },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
            
    ],
    onEditSuccess: (data) => {
        // Aquí defines qué pasa en tu interfaz al cargar los datos
        // mostrarFormProducto = true;  // Mostrar el formulario
        // document.querySelector('#productos-panel').__x.$data.mostrarFormProducto = true;
        // document.getElementById('proveedoresproductosTable').closest('div[x-show]').__x.$data.mostrarFormProducto = true;
        // También podrías cambiar de pestaña si aplica
        // tab = 'productos';
        window.dispatchEvent(new CustomEvent('show-form-servicios'));
    },
};

const proveedoresserviciosModule = new BaseModule(configPS);
proveedoresserviciosModule.init();

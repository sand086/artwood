import { render } from 'nprogress';
import { renderMoneda } from '../../Helpers/utils.js'; 

const agregarIconPP = "/images/icons/crud/iconos_agregar.svg";
const configPM = {
    moduleName: 'ProveedoresMateriales',
    baseUrl: '/proveedoresmateriales/',
    idField: 'proveedor_material_id',
    formFields: ['proveedor_id', 'material_id', 'descripcion', 'unidad_medida_id', 'precio_unitario', 'detalle', 'stock', 'estado'],
    moduleForm: 'proveedoresmaterialesForm',
    moduleTable: 'proveedoresmaterialesTable',
    moduleModal: 'proveedoresModal',
    parentIdField: 'proveedor_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'materiales', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-material',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-material',
    columns: [
        // { data: 'proveedor_id', name: 'proveedor_id', title: 'Proveedor' },
        { data: 'material_nombre', name: 'material_nombre', title: 'Material' },
        { data: 'unidad_medida_nombre', name: 'unidad_medida_nombre', title: 'Unidad Medida' },
        { data: 'precio_unitario', name: 'precio_unitario', title: 'Costo Unitario', render: renderMoneda },
        { data: 'stock', name: 'stock', title: 'Stock' },
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
        window.dispatchEvent(new CustomEvent('show-form-material'));
    },
};

const proveedoresmaterialesModule = new BaseModule(configPM);
proveedoresmaterialesModule.init();
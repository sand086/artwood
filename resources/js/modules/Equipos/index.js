import { renderMoneda } from '../../Helpers/utils.js'; 
// window.MonedaHelpers = { formatearMoneda, desformatearMoneda };

const urlParams = new URLSearchParams(window.location.search);
const openModal = urlParams.get('openModal') === 'true';
const windowClose = urlParams.get('windowClose') === 'true';

const config = {
    moduleName: 'Equipos',
    baseUrl: '/equipos/',
    idField: 'equipo_id',
    formFields: ['nombre', 'descripcion', 'unidad_medida_id', 'precio_unitario'],
    moduleForm: 'equiposForm',
    moduleTable: 'equiposTable',
    moduleModal: 'equiposModal',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'descripcion', name: 'descripcion', title: 'Descripcion' },
        { data: 'unidad_medida_nombre', name: 'unidad_medida_nombre', title: 'Unidad Medida' },
        { data: 'precio_unitario', name: 'precio_unitario', title: 'Costo Unitario', render: renderMoneda },
        { data: 'proveedores', name: 'proveedores', title: 'Proveedores', 
            render: function(data, type, row, meta) {
                return data ?? '';
            } 
        },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
    ],
    openModalOnLoad: openModal, // Parámetro determina si abrir el modal al cargar la página
    windowCloseSave: windowClose, // Parámetro determina si cerrar la ventana al guardar
};

const equiposModule = new BaseModule(config);
equiposModule.init();
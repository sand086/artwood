import '../ClientesContactos/index.js';
import { abrirVentana } from '../../Helpers/utils.js';  // Asegúrate de la ruta
window.abrirVentana = abrirVentana;

const urlParams = new URLSearchParams(window.location.search);
const openModal = urlParams.get('openModal') === 'true';
const windowClose = urlParams.get('windowClose') === 'true';
const clase = urlParams.get('clase') || 'CLIENTES';

const config = {
    moduleName: 'Clientes',
    baseUrl: '/clientes/',
    idField: 'cliente_id',
    formFields: ['nombre', 'tipo_cliente_id', 'clase', 'rfc', 'direccion', 'codigo_postal', 'colonia', 'municipio_id', 
                'estado_pais_id', 'telefono', 'sitio_web', 'notas_adicionales', 'usuario_id'],
    moduleForm: 'clientesForm',
    moduleTable: 'clientesTable',
    moduleModal: 'clientesModal',
    closeModalOnSave: false,
    resetFormOnSave: false,
    targetTab: 'basicos',
    columns: [
        { data: 'nombre', name: 'nombre', title: 'Nombre' },
        { data: 'tipo_cliente_nombre', name: 'tipo_cliente_nombre', title: 'Tipo' },
        { data: 'clase', name: 'clase', title: 'Clase' },
        { data: 'direccion', name: 'direccion', title: 'Direccion' },
        { data: 'colonia', name: 'colonia', title: 'Colonia' },
        { data: 'municipio_nombre', name: 'municipio_nombre', title: 'Municipio' },
        { data: 'estado_pais_nombre', name: 'estado_pais_nombre', title: 'Estado Pais' },
        { data: 'telefono', name: 'telefono', title: 'Telefono' },
        // { data: 'sitio_web', name: 'sitio_web', title: 'Sitio Web' },
        // { data: 'notas_adicionales', name: 'notas_adicionales', title: 'Notas Adicionales' },
        // { data: 'usuario_id', name: 'usuario_id', title: 'Usuario' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
    ],
    openModalOnLoad: openModal, // Parámetro determina si abrir el modal al cargar la página
    windowCloseSave: windowClose, // Parámetro determina si cerrar la ventana al guardar
};

const clientesModule = new BaseModule(config);
clientesModule.init();
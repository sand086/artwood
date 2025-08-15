import { render } from 'nprogress';
import { renderMoneda } from '../../Helpers/utils.js'; 

const urlParams = new URLSearchParams(window.location.search);
const openModal = urlParams.get('openModal') === 'true';
const windowClose = urlParams.get('windowClose') === 'true';
const config = {
    moduleName: "Servicios",
    baseUrl: "/servicios/",
    idField: "servicio_id",
    formFields: ["nombre", "descripcion", "tiempo", "unidad_medida_id", "precio"],
    moduleForm: "serviciosForm",
    moduleTable: "serviciosTable",
    moduleModal: "serviciosModal",
    columns: [
        { data: "nombre", name: "nombre", title: "Nombre" },
        { data: "descripcion", name: "descripcion", title: "Descripcion" },
        { data: "unidad_medida_nombre", name: "unidad_medida_nombre", title: "Unidad Medida"},
        { data: "tiempo", name: "tiempo", title: "Tiempo" },
        { data: "precio", name: "precio", title: "Costo Unitario", render: renderMoneda },
        { data: 'proveedores', name: 'proveedores', title: 'Proveedores' },
        {
            data: "estado",
            name: "estado",
            title: "Estado",
            render: "renderEstado",
            className: "text-center align-middle",
            headerClass: "text-center",
        },
        {
            data: "action",
            name: "action",
            title: "Acciones",
            orderable: false,
            searchable: false,
            className: "text-center align-middle",
            headerClass: "text-center",
        },
    ],
    openModalOnLoad: openModal, // Parámetro determina si abrir el modal al cargar la página
    windowCloseSave: windowClose, // Parámetro determina si cerrar la ventana al guardar
};

const serviciosModule = new BaseModule(config);
serviciosModule.init();

import { renderMoneda } from '../../Helpers/utils.js'; 

const urlParams = new URLSearchParams(window.location.search);
const openModal = urlParams.get("openModal") === "true";
const windowClose = urlParams.get("windowClose") === "true";

const config = {
    moduleName: "Materiales",
    baseUrl: "/materiales/",
    idField: "material_id",
    formFields: [
        "nombre",
        "descripcion",
        "unidad_medida_id",
        "precio_unitario",
    ],
    moduleForm: "materialesForm",
    moduleTable: "materialesTable",
    moduleModal: "materialesModal",
    columns: [

        { data: "nombre", name: "nombre", title: "Nombre" },
        {
            data: "descripcion",
            name: "descripcion",
            title: "Descripci&oacute;on",
        },
        {
            data: "unidad_medida_nombre",
            name: "unidad_medida_nombre",
            title: "Unidad Medida",
        },
        {
            data: "precio_unitario",
            name: "precio_unitario",
            title: "Costo Unitario",
            render: renderMoneda,
        },
        { data: 'proveedores', name: 'proveedores', title: 'Proveedores' },
        {
            data: "estado",
            name: "estado",
            title: "Estado",
            render: "renderEstado",
        },
        {
            data: "action",
            name: "action",
            title: "Acciones",
            orderable: false,
            searchable: false,
        },

    ],
    openModalOnLoad: openModal, // Parámetro determina si abrir el modal al cargar la página
    windowCloseSave: windowClose, // Parámetro determina si cerrar la ventana al guardar
};

const materialesModule = new BaseModule(config);
materialesModule.init();

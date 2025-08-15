import { abrirVentana } from '../../Helpers/utils.js';  // Asegúrate de la ruta
window.abrirVentana = abrirVentana;

const config = {
    moduleName: "Empleados",
    baseUrl: "/empleados/",
    idField: "empleado_id",
    formFields: ["persona_id", "cargo", "usuario_id"],
    moduleForm: "empleadosForm",
    moduleTable: "empleadosTable",
    moduleModal: "empleadosModal",
    columns: [
        { data: "nombre_completo", name: "nombre_completo", title: "Persona" },
        { data: "cargo", name: "cargo", title: "Cargo", className: "text-center align-middle", headerClass: "text-center" },
        { data: "usuario_nombre", name: "usuario_nombre", title: "Usuario" },
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
};

const empleadosModule = new BaseModule(config);
empleadosModule.init();


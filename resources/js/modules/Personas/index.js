const urlParams = new URLSearchParams(window.location.search);
const openModal = urlParams.get('openModal') === 'true';
const windowClose = urlParams.get('windowClose') === 'true';
const config = {
    moduleName: "Personas",
    baseUrl: "/personas/",
    idField: "persona_id",
    formFields: ["nombres", "apellidos", "direccion", "telefono", "correo_electronico", 'tipo_identificacion_id', 'identificador', 'estado_pais_id', 'municipio_id', "colonia", "estado"],
    moduleForm: "personasForm",
    moduleTable: "personasTable",
    moduleModal: "personasModal",
    targetTab: "basicos",
    closeModalOnSave: false, // Determina si se cierra el modal al guardar
    resetFormOnSave: false, // Determina si se reinicia el formulario al guardar
    columns: [
        { data: "nombres", name: "nombres", title: "Nombres" },
        { data: "apellidos", name: "apellidos", title: "Apellidos" },
        { data: "direccion", name: "direccion", title: "Direcci&oacute;n" },
        { data: "telefono", name: "telefono", title: "Tel&eacute;fono" },
        { data: "correo_electronico", name: "correo_electronico", title: "Correo Electr&oacute;nico" },
        { data: "relaciones", name: "relaciones", title: "Relaciones" },
        { data: "estado", name: "estado", title: "Estado", render: "renderEstado" },
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

const personasModule = new BaseModule(config);
personasModule.init();

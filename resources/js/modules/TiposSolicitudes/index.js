const config = {
    moduleName: "TiposSolicitudes",
    baseUrl: "/tipossolicitudes/",
    idField: "tipo_solicitud_id",
    formFields: ["nombre", "descripcion", "estado"],
    moduleForm: "tipossolicitudesForm",
    moduleTable: "tipossolicitudesTable",
    moduleModal: "tipossolicitudesModal",
    columns: [
        { data: "nombre", name: "nombre", title: "Nombre" },
        {
            data: "descripcion",
            name: "descripcion",
            title: "Descripcion",
        },
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

const tipossolicitudesModule = new BaseModule(config);
tipossolicitudesModule.init();

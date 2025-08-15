const config = {
    moduleName: "EstadosGenerales",
    baseUrl: "/estadosgenerales/",
    idField: "estado_general_id",
    formFields: ["nombre", "categoria"],
    moduleForm: "estadosgeneralesForm",
    moduleTable: "estadosgeneralesTable",
    moduleModal: "estadosgeneralesModal",
    columns: [
        { data: "nombre", name: "nombre", title: "Nombre" },
        {
            data: "categoria",
            name: "categoria",
            title: "Categoria",
            className: "text-center align-middle",
            headerClass: "text-center",
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

const estadosgeneralesModule = new BaseModule(config);
estadosgeneralesModule.init();

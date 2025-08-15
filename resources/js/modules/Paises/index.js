const config = {
    moduleName: "Paises",
    baseUrl: "/paises/",
    idField: "pais_id",
    formFields: ["nombre", "codigo_iso"],
    moduleForm: "paisesForm",
    moduleTable: "paisesTable",
    moduleModal: "paisesModal",
    columns: [
        { data: "nombre", name: "nombre", title: "Nombre" },
        { data: "codigo_iso", name: "codigo_iso", title: "Codigo Iso" },
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

const paisesModule = new BaseModule(config);
paisesModule.init();

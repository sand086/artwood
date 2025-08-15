const config = {
    moduleName: "Roles",
    baseUrl: "/roles/",
    idField: "role_id",
    // Campos asignables según el modelo Roles
    formFields: ["name", "guard_name", "descripcion"],
    moduleForm: "rolesForm",
    moduleTable: "rolesTable",
    moduleModal: "rolesModal",
    // Columnas a mostrar en el DataTable
    columns: [
        { data: "role_id", name: "role_id", title: "ID" },
        { data: "name", name: "name", title: "name" },
        { data: "guard_name", name: "guard_name", title: "Guard Name" },
        { data: "descripcion", name: "descripcion", title: "Descripción" },
        {
            data: "estado",
            name: "estado",
            title: "Estado",
            render: "renderEstado",
            orderable: false,
            searchable: false,
        },
        {
            data: "action",
            name: "action",
            title: "Acciones",
            orderable: false,
            searchable: false,
        },
    ],
};

const rolesModule = new BaseModule(config);
rolesModule.init();

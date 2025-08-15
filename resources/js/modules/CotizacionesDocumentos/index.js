const config = {
    moduleName: 'CotizacionesDocumentos',
    baseUrl: '/cotizacionesdocumentos/',
    idField: 'cotizacion_documento_id',
    formFields: ['documento', 'descripcion'],
    // formFields: ['cotizacion_solicitud_id', 'nombre_documento_original', 'nombre_documento_sistema', 'descripcion', 'ruta_almacenamiento', 'tipo_mime', 'tamano_bytes'],
    moduleForm: 'cotizacionesdocumentosForm',
    moduleTable: 'cotizacionesdocumentosTable',
    moduleModal: 'cotizacionessolicitudesModal',
    parentIdField: 'cotizacion_solicitud_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'documentos', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-documento',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-documento',
    columns: [
        { data: 'nombre_documento_original', name: 'nombre_documento_original', title: 'Nombre Documento' },
        { data: 'descripcion', name: 'descripcion', title: 'Descripci&oacute;n' },
        // { data: 'ruta_almacenamiento', name: 'ruta_almacenamiento', title: 'Ruta Almacenamiento' },
        { data: 'tipo_mime', name: 'tipo_mime', title: 'Tipo Mime' },
        { data: 'tamano_bytes', name: 'tamano_bytes', title: 'Tamano Bytes' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false },
    ],
    // onEditSuccess: (data) => {
    //     window.dispatchEvent(new CustomEvent('show-form-documento'));
    // },
};

const cotizacionesdocumentosModule = new BaseModule(config);
cotizacionesdocumentosModule.init();
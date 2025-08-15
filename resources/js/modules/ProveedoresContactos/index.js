const agregarIconPC = "/images/icons/crud/iconos_agregar.svg";
const configPC = {
    moduleName: 'ProveedoresContactos',
    baseUrl: '/proveedorescontactos/',
    idField: 'proveedor_contacto_id',
    formFields: ['proveedor_id', 'persona_id', 'cargo', 'telefono', 'correo_electronico', 'observaciones'],
    moduleForm: 'proveedorescontactosForm',
    moduleTable: 'proveedorescontactosTable',
    moduleModal: 'proveedoresModal', // 'proveedorescontactosModal',
    parentIdField: 'proveedor_id',  // ID del padre del modulo cuando es una pestaña
    closeModalOnSave: false,  // Determina si se cierra el modal al guardar
    resetFormOnSave: true,  // Determina si se reinicia el formulario al guardar
    targetTab: 'contactos', // Nombre de la pestaña a la que se redirige despues de un evento
    formIsInModal: false, // Determina si el formulario está dentro de un modal
    showFormEventName: 'show-form-contacto',  // Nombre del evento para mostrar el formulario
    hideFormEventName: 'hide-form-contacto',
    columns: [
        { data: 'proveedor_id', name: 'proveedor_id', title: 'Proveedor', visible: false },
        { data: 'contacto_nombre_completo', name: 'contacto_nombre_completo', title: 'Contacto' },
        { data: 'cargo', name: 'cargo', title: 'Cargo' },
        { data: 'telefono', name: 'telefono', title: 'Telefono' },
        { data: 'correo_electronico', name: 'correo_electronico', title: 'Correo Electronico' },
        { data: 'estado', name: 'estado', title: 'Estado', render: 'renderEstado' },
        { data: 'action', name: 'action', title: 'Acciones', orderable: false, searchable: false }
    ],
    onEditSuccess: (data) => {
      // Aquí defines qué pasa en tu interfaz al cargar los datos
      // mostrarFormContacto = true;  // Mostrar el formulario
      // document.querySelector('#contactos-panel').__x.$data.mostrarFormContacto = true;
      // document.getElementById('proveedorescontactosTable').closest('div[x-show]').__x.$data.mostrarFormContacto = true;
      // También podrías cambiar de pestaña si aplica
      // tab = 'contactos';
      window.dispatchEvent(new CustomEvent('show-form-contacto'));
    },
};

const proveedorescontactosModule = new BaseModule(configPC);
proveedorescontactosModule.init();

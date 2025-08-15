$(document).ready(function () {
    $("#productos-table").DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('productos.index') }}",
        columns: [
            { data: "producto_id", name: "producto_id" },
            { data: "nombre", name: "nombre" },
            { data: "precio", name: "precio" },
            {
                data: "action",
                name: "action",
                orderable: false,
                searchable: false,
            },
        ],
    });

    $("#createProductForm").on("submit", function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('productos.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
                $("#createProductModal").modal("hide");
                $("#productos-table").DataTable().ajax.reload();
                $("#createProductForm")[0].reset();
            },
            error: function (error) {
                // console.log(error);
            },
        });
    });
});

#!/bin/bash

echo "Actualizando archivos de dependencias..."

# =========================
# Copiar Preline.js
# =========================
if [ ! -f "node_modules/preline/dist/preline.js" ]; then
    echo "ERROR: No se encontró node_modules/preline/dist/preline.js"
else
    mkdir -p "public/js/"
    cp "node_modules/preline/dist/preline.js" "public/js/"
    echo "Librería Preline actualizada ..."
fi

# =========================
# Copiar CSS de DataTables
# =========================

mkdir -p "public/css/datatables"

if [ ! -f "node_modules/datatables.net-dt/css/dataTables.dataTables.min.css" ]; then
    echo "ERROR: No se encontró node_modules/datatables.net-dt/css/dataTables.dataTables.min.css"
else
    cp "node_modules/datatables.net-dt/css/dataTables.dataTables.min.css" "public/css/datatables/datatables.css"
    echo "CSS de DataTables copiado en public/css/datatables/"
fi

if [ ! -f "node_modules/datatables.net-responsive-dt/css/responsive.dataTables.min.css" ]; then
    echo "ERROR: No se encontró node_modules/datatables.net-responsive-dt/css/responsive.dataTables.min.css"
else
    cp "node_modules/datatables.net-responsive-dt/css/responsive.dataTables.min.css" "public/css/datatables/datatables-responsive.css"
    echo "CSS de DataTables Responsive copiado en public/css/datatables/"
fi

if [ ! -f "node_modules/datatables.net-buttons-dt/css/buttons.dataTables.min.css" ]; then
    echo "ERROR: No se encontró node_modules/datatables.net-buttons-dt/css/buttons.dataTables.min.css"
else
    cp "node_modules/datatables.net-buttons-dt/css/buttons.dataTables.min.css" "public/css/datatables/datatables-buttons.css"
    echo "CSS de DataTables Buttons copiado en public/css/datatables/"
fi

echo "==========================================="
echo "Todos los archivos han sido copiados correctamente."
read -p "Presiona Enter para continuar..."

@echo off
setlocal enabledelayedexpansion

echo Actualizando archivos de dependencias...

REM =========================
REM Copiar Preline.js
REM =========================
if not exist node_modules\preline\dist\preline.js (
    echo ERROR: No se encontró node_modules\preline\dist\preline.js
) else (
    if not exist public\js mkdir public\js
    copy /Y "node_modules\preline\dist\preline.js" "public\js\" >nul
    echo Librería Preline actualizada ...
)

REM =========================
REM Copiar CSS de DataTables
REM =========================

if not exist public\css\datatables mkdir public\css\datatables

if not exist node_modules\datatables.net-dt\css\dataTables.dataTables.min.css (
    echo ERROR: No se encontró node_modules\datatables.net-dt\css\dataTables.dataTables.min.css
) else (
    copy /Y "node_modules\datatables.net-dt\css\dataTables.dataTables.min.css" "public\css\datatables\datatables.css" >nul
    echo CSS de DataTables copiado en public\css\datatables\
)

if not exist node_modules\datatables.net-responsive-dt\css\responsive.dataTables.min.css (
    echo ERROR: No se encontró node_modules\datatables.net-responsive-dt\css\responsive.dataTables.min.css
) else (
    copy /Y "node_modules\datatables.net-responsive-dt\css\responsive.dataTables.min.css" "public\css\datatables\datatables-responsive.css" >nul
    echo CSS de DataTables Responsive copiado en public\css\datatables\
)

if not exist node_modules\datatables.net-buttons-dt\css\buttons.dataTables.min.css (
    echo ERROR: No se encontró node_modules\datatables.net-buttons-dt\css\buttons.dataTables.min.css
) else (
    copy /Y "node_modules\datatables.net-buttons-dt\css\buttons.dataTables.min.css" "public\css\datatables\datatables-buttons.css" >nul
    echo CSS de DataTables Buttons copiado en public\css\datatables\
)

echo ===========================================
echo Todos los archivos han sido copiados correctamente.
pause

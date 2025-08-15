@extends('layouts.appP')
@section('title', 'Dashboard – Administración')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="DashboardAdmin">
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Dashboard · Administración</h1>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Usuarios activos (30d)</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">318</h3>
                <p class="text-xs text-green-600 mt-1">+5.4%</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Roles definidos</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">7</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Permisos auditados</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Cambios de catálogos (7d)</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">56</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Áreas, procesos, plantillas</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Uptime</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">99.91%</h3>
                <p class="text-xs text-red-600 mt-1">2 incidentes (30d)</p>
            </div>
        </div>

        <!-- Panel principal -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-col md:flex-row gap-6 mb-8">
            <div class="flex-1">
                <div class="flex flex-wrap justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Inicios de sesión</h3>
                    <div class="flex items-center gap-2 mt-2 md:mt-0">
                        <select class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm">
                            <option>Últimos 30 días</option>
                            <option>Últimos 7 días</option>
                        </select>
                        <button
                            class="text-sm border border-gray-300 dark:border-gray-600 px-2 py-1 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">Descargar
                            log</button>
                    </div>
                </div>
                <div id="chartLogins" style="height: 300px;"></div>
            </div>
            <div class="w-full md:w-64 md:border-l md:pl-4 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Auditoría</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Cambios críticos hoy: <b>4</b></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Pendientes de aprobación: <b>3</b></p>
                </div>
                <div class="mt-4">
                    <button class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90">Revisar
                        permisos</button>
                </div>
            </div>
        </div>

        <!-- Grid de gráficos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Usuarios por rol</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Distribución</p>
                <div id="chartUsuariosRol" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Permisos más usados</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Top 10</p>
                <div id="chartPermisos" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Incidentes (30d)</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Seguridad / Sistema</p>
                <div id="chartIncidentes" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Sesiones por dispositivo</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Desktop vs Mobile</p>
                <div id="chartDispositivos" style="height: 260px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function waitForApex() {
            if (!window.ApexCharts) { return setTimeout(waitForApex, 200); }
            const el = (id) => document.querySelector(id);

            if (el('#chartLogins')) {
                new ApexCharts(el('#chartLogins'), {
                    chart: { type: 'line', height: 300 },
                    series: [{ name: 'Logins', data: [24, 28, 21, 30, 26, 32, 29, 33, 31, 27, 25, 34, 36, 28, 29, 31, 30, 27, 26, 24, 28, 30, 29, 31, 33, 35, 32, 29, 28, 30] }],
                    xaxis: { categories: [...Array(30)].map((_, i) => `D${i + 1}`) }
                }).render();
            }
            if (el('#chartUsuariosRol')) {
                new ApexCharts(el('#chartUsuariosRol'), {
                    chart: { type: 'bar', height: 260 },
                    series: [{ name: 'Usuarios', data: [120, 90, 60, 30, 18, 12, 8] }],
                    xaxis: { categories: ['Operativo', 'Admin', 'Ventas', 'PM', 'Finanzas', 'Técnico', 'Master'] }
                }).render();
            }
            if (el('#chartPermisos')) {
                new ApexCharts(el('#chartPermisos'), {
                    chart: { type: 'bar', height: 260 },
                    series: [{ name: 'Uso', data: [88, 76, 70, 66, 60, 54, 50, 46, 40, 36] }],
                    xaxis: { categories: ['ver_clientes', 'editar_cot', 'aprobar_cot', 'ver_proy', 'editar_proy', 'ver_rep', 'ver_roles', 'ver_perm', 'editar_usu', 'desc_logs'] }
                }).render();
            }
            if (el('#chartIncidentes')) {
                new ApexCharts(el('#chartIncidentes'), {
                    chart: { type: 'bar', height: 260, stacked: true },
                    series: [
                        { name: 'Seguridad', data: [0, 1, 0, 0, 1, 0, 0, 0] },
                        { name: 'Sistema', data: [1, 0, 0, 0, 0, 0, 1, 0] }
                    ],
                    xaxis: { categories: ['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8'] }
                }).render();
            }
            if (el('#chartDispositivos')) {
                new ApexCharts(el('#chartDispositivos'), {
                    chart: { type: 'donut', height: 260 },
                    series: [72, 28],
                    labels: ['Desktop', 'Mobile']
                }).render();
            }
        })();
    </script>
@endpush
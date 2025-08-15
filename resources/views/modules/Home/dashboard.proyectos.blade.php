@extends('layouts.appP')
@section('title', 'Dashboard – Proyectos')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="DashboardProyectos">
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Dashboard · Proyectos</h1>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Proyectos activos</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">42</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Total en curso</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">% on-time</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">86%</h3>
                <p class="text-xs text-green-600 mt-1">+4% vs mes anterior</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Desv. presupuestal</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">-3.1%</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Promedio</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Avance promedio</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">64%</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Entregables</p>
            </div>
        </div>

        <!-- Panel principal -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-col md:flex-row gap-6 mb-8">
            <div class="flex-1">
                <div class="flex flex-wrap justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Avance vs Plan</h3>
                    <div class="flex items-center gap-2 mt-2 md:mt-0">
                        <select class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm">
                            <option>Últimas 8 semanas</option>
                            <option>Últimos 6 meses</option>
                        </select>
                        <button
                            class="text-sm border border-gray-300 dark:border-gray-600 px-2 py-1 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">Ver
                            hitos</button>
                    </div>
                </div>
                <div id="chartAvancePlan" style="height: 300px;"></div>
            </div>
            <div class="w-full md:w-64 md:border-l md:pl-4 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Salud del portafolio</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Retrasados: <b>6</b> · En riesgo: <b>4</b></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Riesgos abiertos: <b>12</b></p>
                </div>
                <div class="mt-4">
                    <button class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90">Asignar
                        recursos</button>
                </div>
            </div>
        </div>

        <!-- Grid de gráficos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Riesgos por severidad</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Abiertos</p>
                <div id="chartRiesgos" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Carga por recurso</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Horas asignadas</p>
                <div id="chartCargaRecurso" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Hitos próximos (7d)</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Fechas clave</p>
                <div id="chartHitos" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Estado por fase</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Stacked</p>
                <div id="chartEstadoFase" style="height: 260px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function waitForApex() {
            if (!window.ApexCharts) { return setTimeout(waitForApex, 200); }
            const el = (id) => document.querySelector(id);

            if (el('#chartAvancePlan')) {
                new ApexCharts(el('#chartAvancePlan'), {
                    chart: { type: 'area', height: 300 },
                    series: [
                        { name: 'Plan', data: [20, 30, 40, 55, 65, 75, 85, 100] },
                        { name: 'Avance', data: [18, 28, 38, 50, 60, 70, 78, 90] }
                    ],
                    xaxis: { categories: ['S1', 'S2', 'S3', 'S4', 'S5', 'S6', 'S7', 'S8'] }
                }).render();
            }
            if (el('#chartRiesgos')) {
                new ApexCharts(el('#chartRiesgos'), {
                    chart: { type: 'donut', height: 260 },
                    series: [3, 6, 3],
                    labels: ['Alta', 'Media', 'Baja']
                }).render();
            }
            if (el('#chartCargaRecurso')) {
                new ApexCharts(el('#chartCargaRecurso'), {
                    chart: { type: 'bar', height: 260 },
                    plotOptions: { bar: { horizontal: true } },
                    series: [{ name: 'Horas', data: [32, 28, 24, 20, 18] }],
                    xaxis: { categories: ['Ana', 'Luis', 'Carla', 'Mario', 'Jorge'] }
                }).render();
            }
            if (el('#chartHitos')) {
                new ApexCharts(el('#chartHitos'), {
                    chart: { type: 'bar', height: 260 },
                    series: [{ name: 'Hitos', data: [2, 1, 3, 0, 2, 1, 1] }],
                    xaxis: { categories: ['L', 'M', 'M', 'J', 'V', 'S', 'D'] }
                }).render();
            }
            if (el('#chartEstadoFase')) {
                new ApexCharts(el('#chartEstadoFase'), {
                    chart: { type: 'bar', stacked: true, height: 260 },
                    series: [
                        { name: 'Planeación', data: [5, 2, 0] },
                        { name: 'Ejecución', data: [12, 3, 1] },
                        { name: 'Cierre', data: [6, 1, 0] }
                    ],
                    xaxis: { categories: ['En tiempo', 'En riesgo', 'Retrasado'] }
                }).render();
            }
        })();
    </script>
@endpush
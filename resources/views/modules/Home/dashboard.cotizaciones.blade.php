@extends('layouts.appP')
@section('title', 'Dashboard – Cotizaciones')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="DashboardCotizaciones">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Dashboard · Cotizaciones</h1>
        </div>

        <!-- KPIs -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Cotizaciones emitidas</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">312</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">Últimos 30 días</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Tasa de conversión</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">28.4%</h3>
                <p class="text-xs text-green-600 mt-1">+2.1% vs mes anterior</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Ticket promedio</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">$18,240</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">MXN</p>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">T. medio de respuesta</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">9.6 h</h3>
                <p class="text-xs text-green-600 mt-1">-1.4 h</p>
            </div>
        </div>

        <!-- Panel principal -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-col md:flex-row gap-6 mb-8">
            <div class="flex-1">
                <div class="flex flex-wrap justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Cotizaciones por estatus</h3>
                    <div class="flex items-center gap-2 mt-2 md:mt-0">
                        <select class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm">
                            <option>Últimos 30 días</option>
                            <option>Últimos 90 días</option>
                        </select>
                        <button
                            class="text-sm border border-gray-300 dark:border-gray-600 px-2 py-1 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700">Exportar</button>
                    </div>
                </div>
                <div id="chartCotEstatus" style="height: 300px;"></div>
            </div>
            <div class="w-full md:w-64 md:border-l md:pl-4 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Resumen</h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ganadas: <b>84</b> · Perdidas: <b>124</b> ·
                        Pendientes: <b>104</b></p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Ingreso potencial: <b>$5.7M</b></p>
                </div>
                <div class="mt-4">
                    <button class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90">Ver
                        detalles</button>
                </div>
            </div>
        </div>

        <!-- Grid de gráficos -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Motivos de pérdida</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Distribución</p>
                <div id="chartMotivosPerdida" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Tiempo de Cotización</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Horas promedio</p>
                <div id="chartTiempoCot" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Top Clientes</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Por monto cotizado</p>
                <div id="chartTopClientes" style="height: 260px;"></div>
            </div>
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Ganado vs Potencial</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Comparativa</p>
                <div id="chartGanadoVsPot" style="height: 260px;"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function waitForApex() {
            if (!window.ApexCharts) { return setTimeout(waitForApex, 200); }

            const el = (id) => document.querySelector(id);
            // Donut: motivos de pérdida
            if (el('#chartMotivosPerdida')) {
                new ApexCharts(el('#chartMotivosPerdida'), {
                    chart: { type: 'donut', height: 260 }, series: [44, 27, 18, 11],
                    labels: ['Precio', 'Alcance', 'Competencia', 'Tiempo']
                }).render();
            }
            // Line: tiempo de cotización
            if (el('#chartTiempoCot')) {
                new ApexCharts(el('#chartTiempoCot'), {
                    chart: { type: 'line', height: 260 }, series: [{ name: 'Horas', data: [12, 10, 11, 9, 8, 10, 9] }],
                    xaxis: { categories: ['L', 'M', 'M', 'J', 'V', 'S', 'D'] }
                }).render();
            }
            // Bar: top clientes
            if (el('#chartTopClientes')) {
                new ApexCharts(el('#chartTopClientes'), {
                    chart: { type: 'bar', height: 260 }, series: [{ name: 'Monto', data: [420, 380, 340, 290, 250] }],
                    xaxis: { categories: ['Cliente A', 'Cliente B', 'Cliente C', 'Cliente D', 'Cliente E'] }
                }).render();
            }
            // Stacked: ganado vs potencial
            if (el('#chartGanadoVsPot')) {
                new ApexCharts(el('#chartGanadoVsPot'), {
                    chart: { type: 'bar', stacked: true, height: 260 },
                    series: [{ name: 'Ganado', data: [120, 150, 180, 160] }, { name: 'Potencial', data: [200, 180, 220, 210] }],
                    xaxis: { categories: ['Q1', 'Q2', 'Q3', 'Q4'] }
                }).render();
            }
            // Estatus principal
            if (el('#chartCotEstatus')) {
                new ApexCharts(el('#chartCotEstatus'), {
                    chart: { type: 'bar', height: 300, stacked: true },
                    series: [
                        { name: 'Ganadas', data: [8, 12, 9, 14, 16, 10] },
                        { name: 'Perdidas', data: [10, 9, 11, 12, 13, 15] },
                        { name: 'Pendientes', data: [6, 7, 9, 8, 10, 12] },
                    ],
                    xaxis: { categories: ['Sem 1', 'Sem 2', 'Sem 3', 'Sem 4', 'Sem 5', 'Sem 6'] }
                }).render();
            }
        })();
    </script>
@endpush
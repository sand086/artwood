@extends('layouts.appP')

@section('title', 'Inicio')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Home">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">Dashboard</h1>
        </div>

        <!-- Tarjetas de estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Card: Ventas -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Ventas</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">$7,820.75</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">
                    51 pedidos <span class="text-green-600 ml-1">+3.2%</span>
                </p>
            </div>
            <!-- Card: Presupuesto -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Presupuesto</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">$835,937.45</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">
                    21 pedidos <span class="text-red-600 ml-1">-4.5%</span>
                </p>
            </div>
            <!-- Card: Pagos -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Pagos</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">$15,503.00</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">86 pedidos</p>
            </div>
            <!-- Card: Cotizaciones -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <p class="text-sm text-gray-500 dark:text-gray-400">Cotizaciones</p>
                <h3 class="text-2xl font-bold mt-1 text-gray-900 dark:text-gray-100">$3,982.53</h3>
                <p class="text-xs text-gray-400 dark:text-gray-300 mt-1">
                    24 pedidos <span class="text-green-600 ml-1">+4.6%</span>
                </p>
            </div>
        </div>

        <!-- Panel con gráfico de proyectos y resumen lateral -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex flex-col md:flex-row gap-6 mb-8">
            <!-- Contenedor del gráfico -->
            <div class="flex-1">
                <div class="flex flex-wrap justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Proyectos</h3>
                    <div class="flex items-center gap-2 mt-2 md:mt-0">
                        <select
                            class="border border-gray-300 dark:border-gray-600 rounded-md px-2 py-1 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400 dark:focus:ring-gray-500">
                            <option>25 Jul - 25 Ago</option>
                            <option>1 Ago - 1 Sep</option>
                        </select>
                        <button
                            class="text-sm border border-gray-300 dark:border-gray-600 px-2 py-1 rounded-md hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-1 focus:ring-gray-400 dark:focus:ring-gray-500">
                            + Agregar concepto
                        </button>
                    </div>
                </div>
                <!-- Gráfico de Proyectos -->
                <div id="chartOrders" style="height: 300px;"></div>
            </div>
            <!-- Resumen lateral -->
            <div class="w-full md:w-64 md:border-l md:pl-4 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Proyectos</h4>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">125,090</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        Resumen general de proyectos con detalles de cotizaciones.
                    </p>
                </div>
                <div class="mt-4">
                    <button class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90">
                        Ver todos los detalles
                    </button><br />
                    <button class="flex items-center px-3 py-2 art-btn-secondary hover:filter hover:brightness-90">
                        Ver todas las ventas
                    </button>
                </div>
            </div>
        </div>

        <!-- Grid de gráficos adicionales -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card: Usuarios -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Usuarios</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Total, Agregados y Eliminados</p>
                <div id="chartUsers"></div>
            </div>
            <!-- Card: Cotizaciones -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Cotizaciones</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Distribución por estatus</p>
                <div id="chartQuotes"></div>
            </div>
            <!-- Card: Tiempo de Cotización -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Tiempo de Cotización</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Promedio (horas) en días hábiles</p>
                <div id="chartQuoteTime"></div>
            </div>
            <!-- Card: Inventario -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Inventario</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Productos vs. Servicios</p>
                <div id="chartProductsServices"></div>
            </div>
        </div>
    </div>
@endsection
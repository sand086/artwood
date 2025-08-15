import { buildChart } from "../../Helpers/buildChart.js";

window.addEventListener("load", () => {
    // Creación de las instancias de los gráficos
    const chartOrders = buildChart(
        "#chartOrders",
        (mode) => ({
            chart: {
                type: "bar",
                height: 300,
                toolbar: { show: false },
            },
            series: [
                {
                    name: "Presupuesto Real",
                    data: [
                        30, 50, 70, 60, 90, 120, 100, 80, 110, 130, 140, 120,
                    ],
                },
                {
                    name: "Presupuesto",
                    data: [20, 40, 60, 55, 85, 100, 90, 60, 100, 120, 130, 110],
                },
            ],
            xaxis: {
                categories: [
                    "Ene",
                    "Feb",
                    "Mar",
                    "Abr",
                    "May",
                    "Jun",
                    "Jul",
                    "Ago",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dic",
                ],
                labels: {
                    style: {
                        colors: mode === "dark" ? "#a3a3a3" : "#9ca3af",
                        fontSize: "13px",
                    },
                },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: mode === "dark" ? "#a3a3a3" : "#9ca3af",
                        fontSize: "13px",
                    },
                },
            },
            legend: { position: "top" },
            dataLabels: { enabled: false },
            grid: { strokeDashArray: 2 },
        }),
        {
            colors: ["#16a34a", "#2563eb"],
        }
    );

    const chartUsers = buildChart(
        "#chartUsers",
        (mode) => ({
            chart: {
                type: "bar",
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            series: [
                {
                    name: "Usuarios",
                    data: [1500, 100, 25],
                },
            ],
            xaxis: {
                categories: ["Total", "Agregados", "Eliminados"],
                labels: {
                    style: {
                        colors: mode === "dark" ? "#a3a3a3" : "#9ca3af",
                        fontSize: "13px",
                    },
                },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: mode === "dark" ? "#a3a3a3" : "#9ca3af",
                        fontSize: "13px",
                    },
                },
            },
            grid: { strokeDashArray: 2 },
            dataLabels: { enabled: false },
            fill: {
                type: "bar",
            },
        }),
        {
            colors: ["#2563eb"],
        }
    );

    const chartQuotes = buildChart(
        "#chartQuotes",
        (mode) => ({
            chart: {
                type: "pie",
                height: 300,
                toolbar: { show: false },
            },
            series: [40, 15, 5],
            labels: ["Aprobadas", "Pendientes", "Rechazadas"],
            legend: { position: "top" },
            dataLabels: { enabled: false },
        }),
        {
            colors: ["#4ade80", "#facc15", "#f87171"],
        }
    );

    const chartQuoteTime = buildChart(
        "#chartQuoteTime",
        (mode) => ({
            chart: {
                type: "line",
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
            },
            series: [
                {
                    name: "Tiempo (horas)",
                    data: [2, 3, 1.5, 2.5, 3],
                },
            ],
            xaxis: {
                categories: ["Lun", "Mar", "Mié", "Jue", "Vie"],
                labels: {
                    style: {
                        colors: mode === "dark" ? "#a3a3a3" : "#9ca3af",
                        fontSize: "13px",
                    },
                },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: mode === "dark" ? "#a3a3a3" : "#9ca3af",
                        fontSize: "13px",
                    },
                },
            },
            dataLabels: { enabled: false },
            stroke: { curve: "straight", width: 2 },
        }),
        {
            colors: ["#9333ea"],
        }
    );

    const chartProductsServices = buildChart(
        "#chartProductsServices",
        (mode) => ({
            chart: {
                type: "donut",
                height: 300,
                toolbar: { show: false },
            },
            series: [120, 80],
            labels: ["Productos", "Servicios"],
            legend: { position: "bottom" },
            dataLabels: { enabled: false },
        }),
        {
            colors: ["#f59e0b", "#3b82f6"],
        }
    );

    // Observador para detectar cambios en el tema (clase "dark" en el html)
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.attributeName === "class") {
                const isDark =
                    document.documentElement.classList.contains("dark");
                const newMode = isDark ? "dark" : "light";
                // Actualizar los gráficos con los nuevos estilos
                chartOrders.updateOptions({
                    xaxis: {
                        labels: {
                            style: {
                                colors:
                                    newMode === "dark" ? "#a3a3a3" : "#9ca3af",
                                useSeriesColors: false,
                                fontWeight: 400,
                            },
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors:
                                    newMode === "dark" ? "#a3a3a3" : "#9ca3af",
                                useSeriesColors: false,
                                fontWeight: 400,
                            },
                        },
                    },
                });
                chartUsers.updateOptions({
                    xaxis: {
                        labels: {
                            style: {
                                colors:
                                    newMode === "dark" ? "#a3a3a3" : "#9ca3af",
                                useSeriesColors: false,
                                fontWeight: 400,
                            },
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors:
                                    newMode === "dark" ? "#a3a3a3" : "#9ca3af",
                                useSeriesColors: false,
                                fontWeight: 400,
                            },
                        },
                    },
                });
                chartQuoteTime.updateOptions({
                    xaxis: {
                        labels: {
                            style: {
                                colors:
                                    newMode === "dark" ? "#a3a3a3" : "#9ca3af",
                                useSeriesColors: false,
                                fontWeight: 400,
                            },
                        },
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors:
                                    newMode === "dark" ? "#a3a3a3" : "#9ca3af",
                                useSeriesColors: false,
                                fontWeight: 400,
                            },
                        },
                    },
                });
                // Para gráficos de tipo pie/donut, si es necesario, se pueden actualizar las opciones de leyenda o etiquetas.
            }
        });
    });
    observer.observe(document.documentElement, { attributes: true });
});

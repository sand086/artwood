import ApexCharts from "apexcharts";

export function buildChart(selector, getOptions, optionsOverride = {}) {
    const isDark = document.documentElement.classList.contains("dark");
    const options = {
        ...getOptions(isDark ? "dark" : "light"),
        ...optionsOverride,
    };
    const chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
    return chart;
}

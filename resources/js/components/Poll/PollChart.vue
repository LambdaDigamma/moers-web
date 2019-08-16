<template>
    <div>
        <canvas id="poll-chart"></canvas>
    </div>
</template>

<script>
    import Chart from 'chart.js';
    import ChartDataLabels from 'chartjs-plugin-datalabels';

    export default {
        name: "PollChart",
        props: {
            chartData: {
                type: Array,
                required: true
            },
            chartLabels: {
                type: Array,
                required: true
            },
        },
        data() {
            return {
                pollData: {
                    type: 'pie',
                    data: {
                        labels: this.chartLabels,
                        datasets: [
                            {
                                data: this.chartData,
                                backgroundColor: [
                                    'blue',
                                    'red',
                                    'green',
                                    'purple',
                                    'orange',
                                    'yellow',
                                    'teal'
                                ],
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: true,
                            position: "bottom",
                            labels: {
                                fontColor: "#333",
                            }
                        },
                        tooltips: {
                            enabled: false
                        },
                        plugins: {
                            datalabels: {
                                formatter: (value, ctx) => {
                                    let sum = 0;
                                    let dataArr = ctx.chart.data.datasets[0].data;
                                    dataArr.map(data => {
                                        sum += data;
                                    });
                                    return (value * 100 / sum).toFixed(2) + "%";
                                },
                                color: '#fff',
                            }
                        }
                    }
                },
            }
        },
        methods: {
            createChart(chartId, chartData) {
                const ctx = document.getElementById(chartId);
                const myChart = new Chart(ctx, {
                    plugins: [ChartDataLabels],
                    type: chartData.type,
                    data: chartData.data,
                    options: chartData.options,
                });
            }
        },
        mounted() {
            this.createChart('poll-chart', this.pollData);
        }
    }
</script>

<style scoped>

</style>
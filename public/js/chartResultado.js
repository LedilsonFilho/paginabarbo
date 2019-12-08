document.addEventListener('DOMContentLoaded', function () {
    var debito = $('#dataChartDebito').data('datachart');
    var credito = $('#dataChartCredito').data('datachart');
    var resultado = $('#dataChartResultado').data('datachart');

    var ctx = document.getElementById("myBarChart");
    var myBarChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
        datasets: [
        {
            label: "Recebido",
            backgroundColor: "#5cb85c",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#5cb85c",
            data: credito,
        },
        {
            label: "Pago",
            backgroundColor: "#d9534f",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#d9534f",
            data: debito,
        },
        {
            label: "Resultado",
            backgroundColor: "#4e73df",
            hoverBackgroundColor: "#2e59d9",
            borderColor: "#4e73df",
            data: resultado,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
        padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
        }
        },
        scales: {
        xAxes: [{
            time: {
            unit: 'Mês'
            },
            gridLines: {
            display: false,
            drawBorder: false
            },
            ticks: {
            maxTicksLimit: 12
            },
            maxBarThickness: 25,
        }],
        yAxes: [{
            ticks: {
            

            maxTicksLimit: 5,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
                return 'R$ ' + number_format(value);
            }
            },
            gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
            }
        }],
        },
        legend: {
        display: true,
        position: 'bottom'
        },
        tooltips: {
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        caretPadding: 10,
        callbacks: {
            label: function (tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            return datasetLabel + ': $' + number_format(tooltipItem.yLabel);
            }
        }
        },
    }
    });

});
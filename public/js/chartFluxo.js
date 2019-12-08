document.addEventListener('DOMContentLoaded', function () {
    var fluxodata = $('#dataCharFluxoData').data('datachart');
    var fluxodebito = $('#dataCharFluxoDebito').data('datachart');
    var fluxocredito = $('#dataCharFluxoCredito').data('datachart');
    var fluxosaldo = $('#dataCharFluxoSaldo').data('datachart');
  
    // dados saldo 
    var correntedate = new Date();
    var anoChar = correntedate.getFullYear();
    var meschar = correntedate.getMonth() + 1;
    var teste = [];
    var ultimoDia = (new Date(anoChar, meschar, 0)).getDate();
    for (var i = 1; i <= ultimoDia; i++) {
      var dia = new Date(anoChar, meschar - 1, i)
      var day = dia.getDate();
      var month = dia.getMonth() + 1;
      var year = dia.getFullYear();
      if (month.toString().length == 1){
        month = "0"+month;      
      }  
      teste.push(day+'/'+month+'/'+year)  
   }
   var arr = Array(ultimoDia);
   var saldoanterior;
   for (var i = 0; i < fluxodata.length; i++) {
     var dataexplodida = fluxodata[i].split("-"); 
     if (meschar == dataexplodida[1]){
      arr[dataexplodida[2]-1] = fluxosaldo[i]; 
     }else{
         saldoanterior = fluxosaldo[i];
     }            
    }
    
    var saldo;
    var hoje = new Date();
    var limite;
    if (meschar != hoje.getMonth() + 1){
      limite = arr.length;
    }else{
      limite =hoje.getDate();
    }    
    for (var i = 0; i < limite; i++) { 
      if (i==0 && arr[i] == null){
          saldo = saldoanterior;
      }  
      if (arr[i] == null){
        arr[i] = saldo;       
      }else{        
        saldo = arr[i];
      }       
     }

    // dados previsão
    var previsaodebito = Array(ultimoDia);
    var previsaocredito = Array(ultimoDia);
    var previsaosaldo = Array(ultimoDia);
    var datalimitedebito;
    var datalimitecredito;

    var tableRefdebito = document.getElementById('tablaagendamentoapagar').getElementsByTagName('tbody')[0];
    var rowCountdebito = tableRefdebito.rows.length;
    for (var i = 0; i < rowCountdebito; i++) {
        var row = tableRefdebito.rows[i];
        var dataexplodida = row.cells[0].innerHTML.split("/");
        datalimitedebito = dataexplodida[0];
        previsaodebito[dataexplodida[0]-1] =  parseFloat(row.cells[2].innerHTML.replace(".", "").replace(",", "."));
    }    
    var tableRefcredito = document.getElementById('tablaagendamentoareceber').getElementsByTagName('tbody')[0];
    var rowCountcredito = tableRefcredito.rows.length;
    for (var i = 0; i < rowCountcredito; i++) {
        var row = tableRefcredito.rows[i];
        var dataexplodida = row.cells[0].innerHTML.split("/");
        datalimitecredito = dataexplodida[0];
        previsaocredito[dataexplodida[0]-1] =  parseFloat(row.cells[2].innerHTML.replace(".", "").replace(",", "."));
    }
    var saldolimite = arr[limite - 1];
    var saldoprevisao;
    var datalimite;
    if ((datalimitedebito == null ? 0 : datalimitedebito)>(datalimitecredito == null ? 0 : datalimitecredito)){
        datalimite = datalimitedebito;
    }else{
        datalimite = datalimitecredito;        
    }     
    for (var i = limite; i < datalimite; i++) {
        if (i==limite){
            saldoprevisao = saldolimite;
            previsaosaldo[i-1] = saldoprevisao;
        }
        saldoprevisao = parseFloat(saldoprevisao) + (previsaocredito[i] == null ? 0 : previsaocredito[i]) - (previsaodebito[i] == null ? 0 : previsaodebito[i]);
        previsaosaldo[i] = saldoprevisao; 
    }
    


  
    //Chart saldo/previsão
    var ctx = document.getElementById("ChartFluxo");
    var myBarChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: teste,
        datasets: [        
          {
            label: "Saldo",    
            borderColor: "#003F87",
            fill: false,
            data: arr,
          },
          {
            label: "Previsão",    
            borderColor: "#B0B0B0",
            borderDash: [10,5], 
            fill: false,
            data: previsaosaldo,
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
              return datasetLabel + ': R$ ' + number_format(tooltipItem.yLabel);
            }
          }
        },
      }
    });
    
  });
  
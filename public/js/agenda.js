window.onload = function(){    
    recuperafiltroagenda()
    localStorage.removeItem('temp_agenda')
}


function filtroagenda(debito, id) {
    localStorage.removeItem('temp_agenda')
    //console.log("filtro");

    var tableRef = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0];   
    var datainicial = document.getElementById('datainicial').value;
    var datafinal = document.getElementById('datafinal').value;

    var rowCount = tableRef.rows.length;
    var itens = [];

    for (var i = 0; i < rowCount; i++) {
        var row = tableRef.rows[i];
        itens.push([row.cells[1].innerHTML, row.cells[2].innerHTML, row.cells[3].innerHTML, row.cells[4].innerHTML, row.cells[5].innerHTML])
    }
    localStorage.setItem('temp_agenda',JSON.stringify(itens));

    post('/agendamentos', { debito: debito, id: id, datainicial: datainicial, datafinal: datafinal}, 'GET');
    

}

function recuperafiltroagenda() {
    var tableRef = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0]; 
    
    var teste = localStorage.getItem('temp_agenda')
    var teste2 = JSON.parse(teste)
    var total = 0;
    
    var rowCount = tableRef.rows.length;        
    for (var i = 0; i < rowCount; i++) {            
        tableRef.deleteRow(row.rowIndex - 1);                    
    }
       
    for(var i = 0; i < teste2.length; i++){

        // Insert a row in the table at the last row
        var newRow = tableRef.insertRow();

        // Insert a cell in the row at index 0
        var newCell0 = newRow.insertCell(0);
        var newCell1 = newRow.insertCell(1);
        var newCell2 = newRow.insertCell(2);
        var newCell3 = newRow.insertCell(3);
        var newCell4 = newRow.insertCell(4);
        var newCell5 = newRow.insertCell(5);

        // Append a text node to the cell
        var auxid = document.createTextNode(teste2[i][0]);
        var auxdata = document.createTextNode(teste2[i][1]);
        var auxdescricao = document.createTextNode(teste2[i][2]);
        var auxvalor = document.createTextNode(teste2[i][3]);
        var botao = document.createElement('label');
        botao.innerHTML = '<label onclick="deleteitemagenda('+ teste2[i][0] +')"><i class="fa fa-minus" aria-hidden="true"></i></label>';
        
        var botaoeditar = document.createElement('a');
        botaoeditar.innerHTML = teste2[i][4];
        
        newCell0.appendChild(botao);
        newCell1.appendChild(auxid);
        newCell2.appendChild(auxdata);
        newCell3.appendChild(auxdescricao);
        newCell4.appendChild(auxvalor);
        newCell5.appendChild(botaoeditar);; 
        
      };

      var rowCount = tableRef.rows.length; 

      for (var i = 0; i < rowCount; i++) {
          var row = tableRef.rows[i];
          total = parseFloat(total) + parseFloat(row.cells[4].innerHTML.replace(".", "").replace(",", "."));

      }
      var totaltexto = document.getElementById('totaltexto');
      totaltexto.innerHTML = total.toFixed(2) // always two decimal digits
          .replace('.', ',') // replace decimal point character with ,
          .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');


}

function salvaragenda(tipo, id) {
    //console.log('SALVAR');
    var tableRef = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0];
    var totaltexto = document.getElementById('totaltexto').innerHTML;
    //console.log(totaltexto);
    //teste = document.getElementById('dataagenda').value;        
    var agendadata = document.getElementById('dataagenda').value;
     var agendadescricao = document.getElementById('agendadescricao').value;
    var rowCount = tableRef.rows.length;
    var itens = [];


    for (var i = 0; i < rowCount; i++) {
        var row = tableRef.rows[i];
        itens.push(row.cells[1].innerHTML)
    }
    localStorage.removeItem('temp_agenda')

    post('/agendamentos', { itens: itens, data: agendadata, descricao: agendadescricao, tipo: tipo, total: totaltexto, id: id}, 'POST');
    //console.log(itens);
}

function additemagenda(id, data, datapag, idconta, iccentrodecusto, notafiscal, descricao, valor, debito, previsao, valorpago) {
    // Get the checkbox
    //console.log("teste");
    //var checkBox = document.getElementById(id);
    var tableRef = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0];
    var total = 0;
    
    // If the checkbox is checked, display the output text
    //if (checkBox.checked == true) {

        //console.log(descricao);


        // Insert a row in the table at the last row
        var newRow = tableRef.insertRow();

        // Insert a cell in the row at index 0
        var newCell0 = newRow.insertCell(0);
        var newCell1 = newRow.insertCell(1);
        var newCell2 = newRow.insertCell(2);
        var newCell3 = newRow.insertCell(3);
        var newCell4 = newRow.insertCell(4);
        var newCell5 = newRow.insertCell(5);

        // Append a text node to the cell
        var auxid = document.createTextNode(id);
        var auxdata = document.createTextNode(data);
        var auxdescricao = document.createTextNode(descricao);
        var auxvalor = document.createTextNode(valor);
        var botao = document.createElement('label');
        botao.innerHTML = '<label onclick="deleteitemagenda('+ id +')"><i class="fa fa-minus" aria-hidden="true"></i></label>';

        var botaoeditar = document.createElement('a');
        botaoeditar.innerHTML = '<a href="#" data-toggle="modal" data-target="#editLancamentoModal" onclick="setaModalEditlancamento(\''+id+'\',\''+data+'\',\''+datapag+'\',\''+idconta+'\',\''+iccentrodecusto+'\',\''+notafiscal+'\',\''+descricao+'\',\''+valor+'\',\''+debito+'\',\''+previsao+'\',\''+valorpago+'\', true)"><i class="fas fa-edit fa-sm"></i>';
        
        newCell0.appendChild(botao);
        newCell1.appendChild(auxid);
        newCell2.appendChild(auxdata);
        newCell3.appendChild(auxdescricao);
        newCell4.appendChild(auxvalor);
        newCell5.appendChild(botaoeditar);

        var rowCount = tableRef.rows.length; 

        for (var i = 0; i < rowCount; i++) {
            var row = tableRef.rows[i];
            total = parseFloat(total) + parseFloat(row.cells[4].innerHTML.replace(".", "").replace(",", "."));

        }
        var totaltexto = document.getElementById('totaltexto');
        totaltexto.innerHTML = total.toFixed(2) // always two decimal digits
            .replace('.', ',') // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');


    /*} else {
        var totaltexto = document.getElementById('totaltexto');
        total = parseFloat(totaltexto.innerHTML.replace(".", "").replace(",", "."));
        //console.log(totaltexto.innerHTML.replace(".", "").replace(",", "."))          
        var rowCount = tableRef.rows.length;
        for (var i = 0; i < rowCount; i++) {
            var row = tableRef.rows[i];
            if (row.cells[0].innerHTML == id) {
                //console.log(row.rowIndex);
                tableRef.deleteRow(row.rowIndex - 1);
                total = parseFloat(total) - parseFloat(row.cells[3].innerHTML.replace(".", "").replace(",", "."));

            }

        }


        totaltexto.innerHTML = total.toFixed(2) // always two decimal digits
            .replace('.', ',') // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
        //tableRef.deleteRow(0); 
    }*/
}

function deleteitemagenda(id) {
    
    var tableRef = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0];
    var total = 0;    
    var totaltexto = document.getElementById('totaltexto');
              
    var rowCount = tableRef.rows.length;        
    for (var i = 0; i < rowCount; i++) {            
        var row = tableRef.rows[i]; 
        try {
            if (row.cells[1].innerHTML == id) {           
                tableRef.deleteRow(row.rowIndex - 1);                    
            }
         }
         catch (e) {
            // declarações para manipular quaisquer exceções
            console.log(e); // passa o objeto de exceção para o manipulador de erro
         }          
        
    }
    var tableRef2 = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0];
    var rowCount2 = tableRef2.rows.length;
    for (var i = 0; i < rowCount2; i++) {
        var row = tableRef2.rows[i];
        total = parseFloat(total) + parseFloat(row.cells[4].innerHTML.replace(".", "").replace(",", "."));

    }
    
    totaltexto.innerHTML = total.toFixed(2) // always two decimal digits
        .replace('.', ',') // replace decimal point character with ,
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    
}

function post(path, params, method) {

    // The rest of this code assumes you are not using a library.
    // It can be made less wordy if you use one.
    const form = document.createElement('form');
    form.method = method;
    form.action = path;

    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            const hiddenField = document.createElement('input');
            hiddenField.type = 'hidden';
            hiddenField.name = key;
            hiddenField.value = params[key];

            form.appendChild(hiddenField);
        }
    }

    document.body.appendChild(form);
    form.submit();
}

function deletaagendamento(id) {
    var URL = "/agendamentos/" + id;    

     $.ajax({
        url: URL,
        type: 'DELETE',        
        success: function (result) {
            //alert("success?");
           // $('#deleteLancamentoModal').modal('hide');
            location.reload();
        },
        error: function(xhr, textStatus, errorThrow){
            document.getElementById('testeerro').innerHTML =xhr.responseText;
            //alert();
            $('#deleteLancamentoModal').modal('hide');
        }
        
    }); 
    

    //post('/agendamentos', { itens: itens, data: agendadata, descricao: agendadescricao, tipo: tipo, total: totaltexto}, 'POST');
    console.log(id);
}
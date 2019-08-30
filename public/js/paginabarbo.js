$(document).ready(function(){
    
    document.getElementById("inp").addEventListener("change", readFile);
    document.getElementById("inpnovo").addEventListener("change", readFile);
});

function readFile() {
  
    if (this.files && this.files[0]) {
      
      var FR= new FileReader();
      
      FR.addEventListener("load", function(e) {
        document.getElementById("editifoto").src = e.target.result;
        document.getElementById("editfotob64").value = e.target.result;
        document.getElementById("foto").src = e.target.result;
        document.getElementById("fotob64").value = e.target.result;
      }); 
      
      FR.readAsDataURL( this.files[0] );
    }
    
  }
  
function setaModalEditServico(id, foto, projeto, cliente, descricao, local, data, categoria) {   
    //console.log(foto);    
    document.getElementById('formularioeditservico').action="/servico/"+id;    
    document.getElementById('editprojetos').value = projeto;
    document.getElementById('editcliente').value = cliente;
    document.getElementById('editlocal').value = local;
    document.getElementById('editdata').value = data;
    document.getElementById('editcategoria').value = categoria;
    document.getElementById('editdescricao').value = descricao;
    document.getElementById('editifoto').src = foto;  
    document.getElementById("editfotob64").value = foto;  
}

function setaModalDeletaServico(id, foto, projeto, cliente, descricao, local, data, categoria) {   
    //console.log(foto);    
    document.getElementById('formulariodeleteservico').action="/servico/"+id;   
    document.getElementById('deleteidsevico').value = id;
    document.getElementById('deleteprojetos').innerHTML = projeto;
    document.getElementById('deletecliente').innerHTML = cliente;
    document.getElementById('deletelocal').innerHTML = local;
    document.getElementById('deletedata').innerHTML = data;
    document.getElementById('deletecategoria').innerHTML = categoria;
    document.getElementById('deletedescricao').innerHTML = descricao;
    document.getElementById('deletefoto').src = foto;  
    document.getElementById("deletefotob64").innerHTML = foto;  
}

function deletaservico() { 
    console.log( document.getElementById('deleteidsevico').value);

    var URL = "/servico/" + document.getElementById('deleteidsevico').value;    

     $.ajax({
        url: URL,
        type: 'DELETE',        
        success: function (result) {
            //alert("success?");
           // $('#deleteLancamentoModal').modal('hide');
            location.reload();
        },
        error: function(xhr, textStatus, errorThrow){
            alert("ERRO - Não é possível apagar se houver lançamentos utilizando esse centro de custo");
            $('#deleteLancamentoModal').modal('hide');
        }
        
    }); 
}

function graficocentrodecusto(e){   
    window.location = '/dashboard?graficocc=' + e.target.value;
  }

function toggle_form_element(select, modal) {    
    if (modal == 'modal'){
        if (select.value == '1') {
            document.getElementById('editformbaixa').style.display = 'none';
            document.getElementById('editformbaixa1').style.display = 'none';
        } else if (select.value == '0') {           
            document.getElementById('editformbaixa').style.display = 'block';
            document.getElementById('editformbaixa1').style.display = 'block';
        } else {
            document.getElementById('editformbaixa').style.display = 'none';
            document.getElementById('editformbaixa1').style.display = 'none';
        }
 
    }else{
        if (select.value == '1') {            
            document.getElementById('formbaixa').style.display = 'none';
            document.getElementById('formbaixa1').style.display = 'none';
        } else if (select.value == '0') {
            datavenc = document.getElementById('data').value;
            valor1 = document.getElementById('valor').value;
            document.getElementById('datapag').value = datavenc;
            document.getElementById('valorpago').value = valor1;
            document.getElementById('formbaixa').style.display = 'block';
            document.getElementById('formbaixa1').style.display = 'block';
        } else {
            document.getElementById('formbaixa').style.display = 'none';
            document.getElementById('formbaixa1').style.display = 'none';
        }
    }
}

function setaModalEditlancamento(Idlancamento, data, datapag, idconta, centrodecusto, notafiscal, descricao, valor,  debito,  previsao,  valorpago, baixa) {   
    console.log(Idlancamento);
    (previsao == 1) ? previsao = "1" : previsao = "0";
    (debito == 1) ? debito = "1" : debito = "0"; 

    if (previsao == 1) {
        document.getElementById('editformbaixa').style.display = 'none';
        document.getElementById('editformbaixa1').style.display = 'none';
    } else if (previsao == 0) {
        document.getElementById('editformbaixa').style.display = 'block';
        document.getElementById('editformbaixa1').style.display = 'block';
    } else {
        document.getElementById('editformbaixa').style.display = 'none';
        document.getElementById('editformbaixa1').style.display = 'none';
    }

    var radios = document.getElementsByName("debito");
    for (var i = 0; i < radios.length; i++) {        
        if (radios[i].value === debito && radios[i].id == "editdebito") { 
            radios[i].checked = true;
        }
    }
    if (baixa == true){
        document.getElementById('formularioeditlancamento').action="/baixa/"+Idlancamento;

    }else{
        document.getElementById('formularioeditlancamento').action="/lancamentos/"+Idlancamento;
    }
          
    document.getElementById('editdata').value = data;
    document.getElementById('editdatapag').value = datapag;
    document.getElementById('editidconta').value = idconta;
    document.getElementById('editcentrodecusto').value = centrodecusto;
    document.getElementById('editnotafiscal').value = notafiscal;
    document.getElementById('editdescricao').value = descricao;
    document.getElementById('editvalor').value = valor;    
    document.getElementById('editprevisao').value = previsao;
    document.getElementById('editvalorpago').value = valorpago;
    
    
}

function setaModalDeletLancamento(Idlancamento, lancdata, datapag, idconta, iccentrodecusto, notafiscal, descricao, valor ) {    
    document.getElementById('idlancamentodelete').value = Idlancamento;
    document.getElementById('lancdata').innerHTML  = "Data Vencimento: " + lancdata;
    document.getElementById('lancdatapag').innerHTML = "Data Pagamento: " + datapag;    
    document.getElementById('lancidconta').innerHTML = "Conta: " + idconta;
    document.getElementById('lanciccentrodecusto').innerHTML = "Centro de custo: " + iccentrodecusto;
    document.getElementById('lancnotafiscal').innerHTML = "Nota Fiscal: " + notafiscal;
    document.getElementById('lancdescricao').innerHTML = "Descrição: " + descricao;
    document.getElementById('lancvalor').innerHTML = "Valor: " + valor;
}

function deletalancamento() { 

    var URL = "/lancamentos/" + document.getElementById('idlancamentodelete').value;    

     $.ajax({
        url: URL,
        type: 'DELETE',        
        success: function (result) {
            //alert("success?");
           // $('#deleteLancamentoModal').modal('hide');
            location.reload();
        },
        error: function(xhr, textStatus, errorThrow){
            alert("ERRO - Não é possível apagar se houver lançamentos utilizando esse centro de custo");
            $('#deleteLancamentoModal').modal('hide');
        }
        
    }); 
}



//Centro de Custo

function setaModalEditCc(idcentrodecusto, nome, descricao) {     
    document.getElementById('formeditcentrodecusto').action="/centrodecusto/"+idcentrodecusto;    
    document.getElementById('editnome').value = nome;
    document.getElementById('editdescricao').value = descricao;
}

function setaModalDeletCc(idcentrodecusto, nome, descricao) {      
    document.getElementById('idcentrodecustodelete').value = idcentrodecusto;
    document.getElementById('labelnome').innerHTML  = "Nome: " + nome;
    document.getElementById('labeldescricao').innerHTML = "Descreição: " + descricao;
}

function deletacentrodecusto() { 
    var URL = "/centrodecusto/" + document.getElementById('idcentrodecustodelete').value;   

     $.ajax({
        url: URL,
        type: 'DELETE',        
        success: function (result) {
            //alert("success?");
            $('#editModal').modal('hide');
            location.reload();
        },
        error: function(xhr, textStatus, errorThrow){
            alert("ERRO - Não é possível apagar se houver lançamentos utilizando esse centro de custo");
            $('#deleteccModal').modal('hide');
        }
        
    });
}


//Conta Corrente

function setaModalEditConta(idcontacorrente, editag, editcc, editnomeconta, editgerente, editdescricaoconta, editenderecoag){       
    document.getElementById('formmodaledit').action="/contacorrente/"+idcontacorrente;
    document.getElementById('idcontacorrenteedit').value = idcontacorrente;
    document.getElementById('editag').value = editag;
    document.getElementById('editcc').value = editcc;
    document.getElementById('editnomeconta').value = editnomeconta;
    document.getElementById('editgerente').value = editgerente;
    document.getElementById('editdescricaoconta').value = editdescricaoconta;
    document.getElementById('editenderecoag').value = editenderecoag;

}

function setaModalDeletConta(idcontacorrentedelete, deleteag, deletecc, deletenomeconta, deletegerente, deletedescricaoconta, deleteenderecoag) {        
    document.getElementById('formdelaconta').action = "/contacorrente/"+idcontacorrentedelete;
    document.getElementById('idcontacorrentedelete').value = idcontacorrentedelete;
    document.getElementById('deleteag').innerHTML  = "Agência: " + deleteag;
    document.getElementById('deletecc').innerHTML = "Conta: " + deletecc;
    document.getElementById('deletenomeconta').innerHTML = "Nome: " + deletenomeconta;
    document.getElementById('deletegerente').innerHTML = "Gerênte: " + deletegerente;
    document.getElementById('deletedescricaoconta').innerHTML = "Descrição: " + deletedescricaoconta;
    document.getElementById('deleteenderecoag').innerHTML = "Endereço: " + deleteenderecoag;
}

function deletacontacorrente() { 
    var URL = "/contacorrente/" + document.getElementById('idcontacorrentedelete').value;    

     $.ajax({
        url: URL,
        type: 'DELETE',        
        success: function (result) {
            //alert("success?");
            $('#editModal').modal('hide');
            location.reload();
        },
        error: function(xhr, textStatus, errorThrow){
            alert("ERRO - Não é possível apagar se houver lançamentos utilizando esta Conta Corrente");
            $('#deletecontaModal').modal('hide');
        }
        
    });
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
        itens.push(row.cells[0].innerHTML)
    }

    post('/agendamentos', { itens: itens, data: agendadata, descricao: agendadescricao, tipo: tipo, total: totaltexto, id: id}, 'POST');
    //console.log(itens);
}
function additemagenda(id, data, descricao, valor) {
    // Get the checkbox
    var checkBox = document.getElementById(id);
    var tableRef = document.getElementById('tablaagendamento').getElementsByTagName('tbody')[0];
    var total = 0;

    // If the checkbox is checked, display the output text
    if (checkBox.checked == true) {

        //console.log(descricao);


        // Insert a row in the table at the last row
        var newRow = tableRef.insertRow();

        // Insert a cell in the row at index 0
        var newCell0 = newRow.insertCell(0);
        var newCell1 = newRow.insertCell(1);
        var newCell2 = newRow.insertCell(2);
        var newCell3 = newRow.insertCell(3);

        // Append a text node to the cell
        var auxid = document.createTextNode(id);
        var auxdata = document.createTextNode(data);
        var auxdescricao = document.createTextNode(descricao);
        var auxvalor = document.createTextNode(valor);
        newCell0.appendChild(auxid);
        newCell1.appendChild(auxdata);
        newCell2.appendChild(auxdescricao);
        newCell3.appendChild(auxvalor);

        var rowCount = tableRef.rows.length;

        for (var i = 0; i < rowCount; i++) {
            var row = tableRef.rows[i];
            total = parseFloat(total) + parseFloat(row.cells[3].innerHTML.replace(".", "").replace(",", "."));

        }
        var totaltexto = document.getElementById('totaltexto');
        totaltexto.innerHTML = total.toFixed(2) // always two decimal digits
            .replace('.', ',') // replace decimal point character with ,
            .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');


    } else {
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
    }
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




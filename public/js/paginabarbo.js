$(document).ready(function(){ 
    saldoagendamentodash()   
    document.getElementById("inp").addEventListener("change", readFile);
    document.getElementById("inpnovo").addEventListener("change", readFile);
    
});

function saldoagendamentodash(){
    var tableRefdebito = document.getElementById('tablaagendamentoapagar').getElementsByTagName('tbody')[0]; 
    var rowCountdebito = tableRefdebito.rows.length;
    var totaldebito = 0;
    var tableRefcredito = document.getElementById('tablaagendamentoareceber').getElementsByTagName('tbody')[0]; 
    var rowCountcredito = tableRefcredito.rows.length;
    var totalcredito = 0;

    for (var i = 0; i < rowCountdebito; i++) {
        var row = tableRefdebito.rows[i];
        totaldebito = parseFloat(totaldebito) + parseFloat(row.cells[2].innerHTML.replace(".", "").replace(",", "."));

    }
    for (var i = 0; i < rowCountcredito; i++) {
        var row = tableRefcredito.rows[i];
        totalcredito = parseFloat(totalcredito) + parseFloat(row.cells[2].innerHTML.replace(".", "").replace(",", "."));

    }
    var totaltextodebito = document.getElementById('totalagendamentodebito');
    totaltextodebito.innerHTML = 'Total R$ ' + totaldebito.toFixed(2) // always two decimal digits
        .replace('.', ',') // replace decimal point character with ,
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
    var totaltextocredito = document.getElementById('totalagendamentocredito');
    totaltextocredito.innerHTML = 'Total R$ ' + totalcredito.toFixed(2) // always two decimal digits
        .replace('.', ',') // replace decimal point character with ,
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');

}

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
 
    }else if (modal == 'modalrepete') {
        if (select.value == '1') {
            document.getElementById('repeteformbaixa').style.display = 'none';
            document.getElementById('repeteformbaixa1').style.display = 'none';
        } else if (select.value == '0') {           
            document.getElementById('repeteformbaixa').style.display = 'block';
            document.getElementById('repeteformbaixa1').style.display = 'block';
        } else {
            document.getElementById('repeteformbaixa').style.display = 'none';
            document.getElementById('repeteformbaixa1').style.display = 'none';
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

function teste(id, data, datapag, idconta, iccentrodecusto, notafiscal, descricao, valor, debito, previsao, valorpago){
    console.log("tesye")
    console.log(id);
    console.log(data);
    console.log(datapag);
    console.log(idconta);
    var teste = '<a href="#" data-toggle="modal" data-target="#editLancamentoModal" onclick="teste(\''+id+'\',\''+data+'\',\''+datapag+'\',\''+iccentrodecusto+'\',\''+notafiscal+'\',\''+descricao+'\',\''+valor+'\',\''+debito+'\',\''+previsao+'\',\''+valorpago+')"><i class="fas fa-edit fa-sm"></i>';
    console.log(teste)
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

function setaModalRepetelancamento(Idlancamento, data, datapag, idconta, centrodecusto, notafiscal, descricao, valor,  debito,  previsao,  valorpago, baixa) {   
    console.log(Idlancamento);
    (previsao == 1) ? previsao = "1" : previsao = "0";
    (debito == 1) ? debito = "1" : debito = "0"; 

    if (previsao == 1) {
        document.getElementById('repeteformbaixa').style.display = 'none';
        document.getElementById('repeteformbaixa1').style.display = 'none';
    } else if (previsao == 0) {
        document.getElementById('repeteformbaixa').style.display = 'block';
        document.getElementById('repeteformbaixa1').style.display = 'block';
    } else {
        document.getElementById('repeteformbaixa').style.display = 'none';
        document.getElementById('repeteformbaixa1').style.display = 'none';
    }

    var radios = document.getElementsByName("debito");
    for (var i = 0; i < radios.length; i++) {        
        if (radios[i].value === debito && radios[i].id == "repetedebito") { 
            radios[i].checked = true;
        }
    }
   
          
    document.getElementById('repetedata').value = data;
    document.getElementById('repetedatapag').value = datapag;
    document.getElementById('repeteidconta').value = idconta;
    document.getElementById('repetecentrodecusto').value = centrodecusto;
    document.getElementById('repetenotafiscal').value = notafiscal;
    document.getElementById('repetedescricao').value = descricao;
    document.getElementById('repetevalor').value = valor;    
    document.getElementById('repeteprevisao').value = previsao;
    document.getElementById('repetevalorpago').value = valorpago;
    
    
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





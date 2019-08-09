// Call the dataTables jQuery plugin
$(document).ready(function () {

  $('#tablelancamento').DataTable({
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Nada encontrado",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "Nenhum registro disponível",
      "infoFiltered": "(filtrado de _MAX_ registros no total)"
    },
    "ordering": false
  });
  $('#tablecentrodecusto').DataTable({
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Nada encontrado",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "Nenhum registro disponível",
      "infoFiltered": "(filtrado de _MAX_ registros no total)"
    }
  });
  $('#tablecontasapagar').DataTable({
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Nada encontrado",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "Nenhum registro disponível",
      "infoFiltered": "(filtrado de _MAX_ registros no total)"
    }
  });
  $('#tablecontasareceber').DataTable({
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Nada encontrado",
      "info": "Mostrando página _PAGE_ de _PAGES_",
      "infoEmpty": "Nenhum registro disponível",
      "infoFiltered": "(filtrado de _MAX_ registros no total)"
    }
  });
});


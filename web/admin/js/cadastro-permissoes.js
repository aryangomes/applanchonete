
$(document).ready(function(){
 


  console.log('teste');

  $('#user-sortable').sortable().bind('sortupdate', function(e, ui) {
   
   if (ui.item.data().name == 'user' && ($('#user-sortable li').length <= 1)) {

     var arrayuservalues = ['index-user','view-user','create-user','update-user','delete-user'];
     var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];


     for (i = 0; i < arrayuservalues.length; i++) { 
      if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
        arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
      }
    /*  $('#user-sortable').append('<li data-name='+arrayuservalues[i]+' data-key='+arrayuservalues[i]
        +'  >'+arrayusertext[i] + ' Usuário'+
        '</li>');

      "<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role="option" aria-grabbed="false" draggable="true">"+arrayusertext[i] + " Usuários</li>"
      */
      $(this).append("<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >"+arrayusertext[i] + " Usuários</li>");
      $("[data-name=\'user\']").text('Usuário');

      $(this).sortable();
      console.log(arrayuservalues[i]);

    }

    $("#w0-sortable [data-name*='user']").remove();
  }
});




$('#fornecedor-sortable').sortable().bind('sortupdate', function(e, ui) {
 if (ui.item.data().name == 'fornecedor' 
   && ($('#fornecedor-sortable li').length <= 1)) {

   var arrayuservalues = ['index-fornecedor','view-fornecedor','create-fornecedor','update-fornecedor','delete-fornecedor'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];


 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
    arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
  }

  $(this).append("<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >"+arrayusertext[i] + " Fornecedores</li>");
  $("[data-name=\'fornecedor\']").text('Fornecedor');

  $(this).sortable();
  console.log(arrayuservalues[i]);

}

$("#w0-sortable [data-name*='fornecedor']").remove();
}
});



$('#relatorio-sortable').sortable().bind('sortupdate', function(e, ui) {
 if (ui.item.data().name == 'relatorio' 
   && ($('#relatorio-sortable li').length <= 1)) {

   var arrayuservalues = ['index-relatorio','view-relatorio','create-relatorio','update-relatorio','delete-relatorio'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];


 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
    arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
  }

  $(this).append("<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >"+arrayusertext[i] + " Relatórios</li>");
  $("[data-name=\'relatorio\']").text('Relatório');

  $(this).sortable();
  console.log(arrayuservalues[i]);

}

$("#w0-sortable [data-name*='relatorio']").remove();
}
});

$('#compra-sortable').sortable().bind('sortupdate', function(e, ui) {
 if (ui.item.data().name == 'compra'
   && ($('#compra-sortable li').length <= 1)) {

   var arrayuservalues = ['index-compra','view-compra','create-compra','update-compra','delete-compra'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];


 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
    arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
  }

  $(this).append("<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >"+arrayusertext[i] + " Compras</li>");
  $("[data-name=\'compra\']").text('Compra');

  $(this).sortable();
  console.log(arrayuservalues[i]);

}

$("#w0-sortable [data-name*='compra']").remove();
}
});


$('#caixa-sortable').sortable().bind('sortupdate', function(e, ui) {
 if (ui.item.data().name == 'caixa'
  && ($('#caixa-sortable li').length <= 1)) {

   var arrayuservalues = ['index-caixa','view-caixa','create-caixa','update-caixa','delete-compra'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];


 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
    arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
  }

  $(this).append("<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >"+arrayusertext[i] + " Caixa</li>");
  $("[data-name=\'caixa\']").text('Caixa');

  $(this).sortable();
  console.log(arrayuservalues[i]);

}

$("#w0-sortable [data-name*='caixa']").remove();
}
});

$('#despesa-sortable').sortable().bind('sortupdate', function(e, ui) {
 if (ui.item.data().name == 'despesa'
  && ($('#despesa-sortable li').length <= 1)) {

   var arrayuservalues = ['index-despesa','view-despesa','create-despesa','update-despesa','delete-despesa'];
 var arrayusertext = ['Listar','Visualizar','Criar','Editar','Deletar'];


 for (i = 0; i < arrayuservalues.length; i++) { 
  if (arrayvalues.indexOf(arrayuservalues[i]) >= 0) {
    arrayvalues.splice(arrayvalues.indexOf(arrayuservalues[i]), 1);
  }

  $(this).append("<li data-name="+arrayuservalues[i]+" data-key="+arrayuservalues[i]+" role=\"option\" aria-grabbed=\"false\" draggable=\"true\" style=\"display: list-item;\" >"+arrayusertext[i] + " Despesas</li>");
  $("[data-name=\'despesa\']").text('Despesa');

  $(this).sortable();
  console.log(arrayuservalues[i]);

}

$("#w0-sortable [data-name*='despesa']").remove();
}
});

});
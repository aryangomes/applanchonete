/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var data = [{id: 0, text: 'enhancement'}, {id: 1, text: 'bug'}, {id: 2, text: 'duplicate'}, {id: 3, text: 'invalid'}, {id: 4, text: 'wontfix'}];


var countItemPedido = 1;
$("#btRemoverItemPedido1").prop("disabled",true);

$("#btAdicionarItemPedido").click(function () {

    countItemPedido++;
    console.log(countItemPedido);
    $("#more-item-pedido").append("<div class='form-group' id='ip" + countItemPedido + "'> </div>");
    $("#ip1").clone().appendTo("#ip" + countItemPedido );
        $("#ip" + countItemPedido ).append('<button type="button" \n\
    id="btRemoverItemPedido" '+countItemPedido+' class="btn btn-default"\n\
     onclick="removerItemPedido('+countItemPedido+')">Remover Item Pedido</button>');
    $("#ip" + countItemPedido + " select[id^='select1']")
            .prop("id", "select" + countItemPedido);
     $("#ip" + countItemPedido + " button[id^='btRemoverItemPedido1']")
            .remove();
    
    $("#select" + countItemPedido).prop("disabled", false);
    $("#btRemoverItemPedido"+ countItemPedido).prop("disabled",false);
    $("#select" + countItemPedido).select2();
    
});


function removerItemPedido(id) {
   
    $("#ip" + id).empty();

}
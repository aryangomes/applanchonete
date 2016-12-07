/**
 * Created by aryan on 22/11/16.
 */


var produtosSelecionadosBloqueados = [];

var produtosSelecionados = [];

var teste = true;

function verificaCompraProduto(element) {
    var idProduto = (element.value);

    if(idProduto != 0 && idProduto != ''){
        $.get('../produto/get-compra-produto', {
            idProduto: idProduto
        }, function (data) {

            // var data = $.parseJSON(data);
            console.log(data);
            if (data == 'false') {

                alert('O insumo escolhido não possui compra registrada, logo não se poderá fazer o cálculo de custo do Produto Venda.' +
                    'Para resolver isso, faça o registro da compra do insumo escolhido');

               produtosSelecionadosBloqueados.push(idProduto);
                $('#btSalvarProduto').prop('disabled',true);
                // $$('#btSalvarProduto')"#insumo-idprodutoinsumo").children('option[value="' +  $("#insumo-idprodutoinsumo").val() + '"]').attr('disabled', true)
            }else{
                $('#btSalvarProduto').prop('disabled',false);
                produtosSelecionados.push(idProduto);
            }


        });
    }

}

// $('#btSalvarProduto').prop('disabled',false);
$('#btSalvarProduto').click(function () {

    $.each(produtosSelecionadosBloqueados, function (index,elemento) {
        if(produtosSelecionados.indexOf(elemento) > -1){
            teste = false;
        }
    });

    if(teste){
        $(this).prop('disabled',false);
        $(this).submit();
    }else{
        $(this).prop('disabled',true);

    }
});